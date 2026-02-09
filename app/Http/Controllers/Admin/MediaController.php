<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaFile::with('user');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('file_type', $request->type);
        }

        // Filter by folder
        if ($request->filled('folder')) {
            $query->where('folder', $request->folder);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('original_name', 'like', '%' . $request->search . '%');
            });
        }

        $files = $query->latest()->paginate(24);

        // Get folders for filter
        $folders = MediaFile::select('folder')
            ->distinct()
            ->orderBy('folder')
            ->pluck('folder');

        return view('admin.media.index', compact('files', 'folders'));
    }

    public function upload(Request $request)
    {
        // Force JSON response if Accept header is application/json
        $wantsJson = $request->wantsJson() || $request->expectsJson() || $request->ajax();
        
        try {
            $request->validate([
                'files' => 'required|array',
                'files.*' => 'file|mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx,xls,xlsx,zip|max:10240', // 10MB max
                'folder' => 'nullable|string',
            ]);

            $uploadedFiles = [];
            $folder = $request->folder ?: '/';

            foreach ($request->file('files') as $file) {
                try {
                    $uploadedFile = $this->processUpload($file, $folder);
                    $uploadedFiles[] = $uploadedFile;
                } catch (\Exception $e) {
                    \Log::error('Upload failed for file: ' . $file->getClientOriginalName() . ' - Error: ' . $e->getMessage());
                    \Log::error('Stack trace: ' . $e->getTraceAsString());
                    
                    if ($wantsJson) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Upload failed: ' . $e->getMessage()
                        ], 500);
                    }
                    
                    return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
                }
            }

            if ($wantsJson) {
                return response()->json([
                    'success' => true,
                    'files' => collect($uploadedFiles)->map(function($file) {
                        return [
                            'id' => $file->id,
                            'name' => $file->name,
                            'url' => $file->url,
                            'file_path' => $file->file_path,
                            'thumbnail_url' => $file->thumbnail_url,
                        ];
                    }),
                    'message' => count($uploadedFiles) . ' file(s) berhasil diupload!'
                ]);
            }

            return redirect()->route('admin.media.index')
                ->with('success', count($uploadedFiles) . ' file(s) berhasil diupload!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($wantsJson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $e->errors()['files'] ?? ['Invalid file'])
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Upload controller error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($wantsJson) {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload failed: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    private function processUpload($file, $folder)
    {
        try {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();
            $size = $file->getSize();

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $extension;
            $folderPath = 'media' . ($folder !== '/' ? '/' . trim($folder, '/') : '');
            
            // Store file - FIXED: use storeAs without 'public/' prefix
            $path = $file->storeAs($folderPath, $filename, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to store file to disk');
            }

            // Determine file type
            $fileType = $this->getFileType($mimeType);

            // Process image if it's an image
            $dimensions = null;
            if ($fileType === 'image') {
                try {
                    $dimensions = $this->processImage($path);
                } catch (\Exception $e) {
                    \Log::warning('Failed to process image: ' . $e->getMessage());
                    // Continue without dimensions
                }
            }

            // Save to database
            $mediaFile = MediaFile::create([
                'name' => pathinfo($originalName, PATHINFO_FILENAME),
                'original_name' => $originalName,
                'file_path' => $path,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
                'file_size' => $size,
                'dimensions' => $dimensions,
                'user_id' => Auth::id(),
                'folder' => $folder,
            ]);

            return $mediaFile;
        } catch (\Exception $e) {
            \Log::error('Upload processing failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } elseif (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        } else {
            return 'document';
        }
    }

    private function processImage($path)
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read(storage_path('app/public/' . $path));
            
            $width = $image->width();
            $height = $image->height();

            // Tidak buat thumbnail lagi - langsung return dimensions
            return ['width' => $width, 'height' => $height];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function show(MediaFile $media)
    {
        return view('admin.media.show', compact('media'));
    }

    public function update(Request $request, MediaFile $media)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $media->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media berhasil diupdate!'
            ]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', 'Media berhasil diupdate!');
    }

    public function destroy(MediaFile $media)
    {
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            
            // Delete thumbnail if exists (untuk file lama yang masih punya thumbnail)
            $thumbnailPath = str_replace('.', '_thumb.', $media->file_path);
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            // Delete from database
            $media->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Media berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.media.index')
                ->with('success', 'Media berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Delete media failed: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete media: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to delete media: ' . $e->getMessage());
        }
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent' => 'nullable|string',
        ]);

        $parent = $request->parent ?: '/';
        $folderPath = rtrim($parent, '/') . '/' . $request->name;

        // Create folder in storage
        Storage::makeDirectory('public/media' . $folderPath);

        return response()->json([
            'success' => true,
            'folder' => $folderPath,
            'message' => 'Folder berhasil dibuat!'
        ]);
    }

    public function browse(Request $request)
    {
        $query = MediaFile::query();

        if ($request->filled('type')) {
            $query->where('file_type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $files = $query->latest()->paginate(20);

        return view('admin.media.browse', compact('files'));
    }
}