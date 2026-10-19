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
            $search = safe_like_input($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('original_name', 'like', '%' . $search . '%');
            });
        }

        $perPage = in_array($request->input('per_page'), [12, 24, 48, 96]) ? (int) $request->input('per_page') : 24;
        $files = $query->latest()->paginate($perPage)->withQueryString();

        // Get folders for filter
        $folders = MediaFile::select('folder')
            ->distinct()
            ->orderBy('folder')
            ->pluck('folder');

        return view('admin.media.index', compact('files', 'folders', 'perPage'));
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
                    // Additional security check: validate file content
                    if (!$this->isValidFileContent($file)) {
                        throw new \Exception('File content validation failed for: ' . $file->getClientOriginalName());
                    }

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

    /**
     * Validate file content to prevent malicious uploads
     */
    private function isValidFileContent($file): bool
    {
        $mimeType = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());

        // Check if mime type matches extension
        $validMimeTypes = [
            'jpg' => ['image/jpeg', 'image/jpg'],
            'jpeg' => ['image/jpeg', 'image/jpg'],
            'png' => ['image/png'],
            'gif' => ['image/gif'],
            'webp' => ['image/webp'],
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'xls' => ['application/vnd.ms-excel'],
            'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            'zip' => ['application/zip', 'application/x-zip-compressed'],
        ];

        if (!isset($validMimeTypes[$extension])) {
            return false;
        }

        if (!in_array($mimeType, $validMimeTypes[$extension])) {
            \Log::warning("Mime type mismatch: extension={$extension}, mime={$mimeType}");
            return false;
        }

        // Additional check for images: verify it's actually an image
        if (str_starts_with($mimeType, 'image/')) {
            try {
                $imageInfo = @getimagesize($file->getRealPath());
                if ($imageInfo === false) {
                    \Log::warning("File claims to be image but getimagesize failed");
                    return false;
                }
            } catch (\Exception $e) {
                \Log::warning("Image validation failed: " . $e->getMessage());
                return false;
            }
        }

        // Check for PHP code in files (prevent PHP file upload disguised as other types)
        $content = file_get_contents($file->getRealPath(), false, null, 0, 1024);
        if (preg_match('/<\?php|<\?=|<script.*language.*php/i', $content)) {
            \Log::warning("PHP code detected in uploaded file");
            return false;
        }

        return true;
    }

    private function processUpload($file, $folder)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        // Use cryptographically random filename to prevent collisions on
        // concurrent uploads (uniqid() can collide on fast servers).
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $folderPath = 'media' . ($folder !== '/' ? '/' . trim($folder, '/') : '');

        // Store file first
        $path = $file->storeAs($folderPath, $filename, 'public');

        if (!$path) {
            throw new \Exception('Failed to store file to disk');
        }

        // Wrap DB write in transaction; on any failure, delete the orphan file.
        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use (
                $path, $originalName, $folder, $size, $mimeType
            ) {
                $fileType = $this->getFileType($mimeType);

                // Process image (resize if too large) — best effort.
                $dimensions = null;
                if ($fileType === 'image') {
                    try {
                        $dimensions = $this->processImage($path);
                    } catch (\Exception $e) {
                        \Log::warning('Failed to process image: ' . $e->getMessage());
                    }
                }

                return MediaFile::create([
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
            });
        } catch (\Throwable $e) {
            // Rollback orphan file from disk
            Storage::disk('public')->delete($path);
            \Log::error('Upload rollback: ' . $e->getMessage());
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
            $fullPath = storage_path('app/public/' . $path);
            $image = $manager->read($fullPath);

            $width = $image->width();
            $height = $image->height();

            // Auto-resize: cap max width at 1920px to keep storage/bandwidth small.
            // Aspect ratio preserved by single-axis scaleDown.
            $MAX_WIDTH = 1920;
            if ($width > $MAX_WIDTH) {
                $image->scaleDown(width: $MAX_WIDTH);
                $image->save($fullPath);
                $width = $image->width();
                $height = $image->height();
            }

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
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[\w\-\.\s]+$/',
            // Parent must be either '/' or an absolute path under storage root.
            // Reject any path containing '..', backslash, or null bytes.
            'parent' => ['nullable', 'string', 'max:500', 'regex:/^[\/\w\-\.\s]+$/'],
        ]);

        $parent = $validated['parent'] ?? '/';
        // Normalize and reject path traversal attempts.
        if (str_contains($parent, '..') || str_contains($parent, '\\')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid parent path.',
            ], 422);
        }

        $folderPath = rtrim($parent, '/') . '/' . $validated['name'];
        $absolute = 'media' . $folderPath;

        // Final sanity check: resolved path must still be inside media/
        if (!str_starts_with($absolute, 'media/') || str_contains($absolute, '..')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid folder path.',
            ], 422);
        }

        Storage::disk('public')->makeDirectory($absolute);

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
            $search = safe_like_input($request->search);
            $query->where('name', 'like', '%' . $search . '%');
        }

        $files = $query->latest()->paginate(20);

        return view('admin.media.browse', compact('files'));
    }
}
