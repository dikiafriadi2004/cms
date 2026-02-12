<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('sort_order')->get()->groupBy('group');
        
        // Helper function to get setting value safely
        $getSetting = function($group, $key) use ($settings) {
            $item = $settings->get($group, collect())->where('key', $key)->first();
            return $item ? $item->value : '';
        };
        
        return view('admin.settings.index', compact('settings', 'getSetting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'hero_image' => 'nullable|image|max:5120',
            'og_image' => 'nullable|image|max:2048',
            'ga_credentials_json' => 'nullable|string',
            'ga_property_id' => 'nullable|string|max:50',
        ]);

        // Handle Google Analytics credentials JSON
        if ($request->filled('ga_credentials_json')) {
            $jsonContent = trim($request->ga_credentials_json);
            
            // Validate JSON format
            $json = json_decode($jsonContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()
                    ->withErrors(['ga_credentials_json' => 'Invalid JSON format: ' . json_last_error_msg()])
                    ->withInput();
            }
            
            // Validate required fields
            $requiredFields = ['type', 'project_id', 'private_key', 'client_email'];
            foreach ($requiredFields as $field) {
                if (!isset($json[$field])) {
                    return redirect()->back()
                        ->withErrors(['ga_credentials_json' => "Missing required field: {$field}"])
                        ->withInput();
                }
            }
            
            if ($json['type'] !== 'service_account') {
                return redirect()->back()
                    ->withErrors(['ga_credentials_json' => 'Invalid credentials type. Must be service_account.'])
                    ->withInput();
            }
            
            // Save credentials to database
            Setting::updateOrCreate(
                ['key' => 'ga_credentials_json'],
                [
                    'value' => $jsonContent,
                    'type' => 'textarea',
                    'group' => 'analytics',
                    'label' => 'Google Analytics Credentials',
                    'description' => 'Service Account credentials for Google Analytics API',
                ]
            );
        }

        // Handle Google Analytics Property ID
        if ($request->filled('ga_property_id')) {
            Setting::updateOrCreate(
                ['key' => 'ga_property_id'],
                [
                    'value' => $request->ga_property_id,
                    'type' => 'text',
                    'group' => 'analytics',
                    'label' => 'Google Analytics Property ID',
                    'description' => 'GA4 Property ID for API integration',
                ]
            );
        }

        // Handle separate file uploads (logo, favicon, hero_image, og_image)
        $fileUploads = ['logo', 'favicon', 'hero_image', 'og_image'];
        foreach ($fileUploads as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $path = $file->store('settings', 'public');
                
                // Delete old file if exists
                $oldSetting = Setting::where('key', $fileKey)->first();
                if ($oldSetting && $oldSetting->value) {
                    Storage::disk('public')->delete($oldSetting->value);
                }
                
                // Update or create setting
                Setting::updateOrCreate(
                    ['key' => $fileKey],
                    [
                        'value' => $path,
                        'group' => $fileKey === 'og_image' ? 'seo' : ($fileKey === 'hero_image' ? 'hero' : 'branding'),
                        'type' => 'file',
                        'label' => ucfirst(str_replace('_', ' ', $fileKey)),
                    ]
                );
            }
        }

        foreach ($request->settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting) {
                continue;
            }

            // Handle file uploads
            if ($setting->type === 'file' && $request->hasFile("settings.{$key}")) {
                $file = $request->file("settings.{$key}");
                $path = $file->store('settings', 'public');
                
                // Delete old file if exists
                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                
                $value = $path;
            }

            // Handle boolean values
            if ($setting->type === 'boolean') {
                $value = $value ? '1' : '0';
            }

            // Handle JSON values
            if ($setting->type === 'json' && is_array($value)) {
                $value = json_encode($value);
            }

            $setting->update(['value' => $value]);
        }

        // Clear settings cache
        Setting::clearCache();

        // Reconfigure mail with new settings
        MailConfigService::configure();

        // Clear config cache if analytics was updated
        if ($request->filled('ga_credentials_json') || $request->filled('ga_property_id')) {
            \Artisan::call('config:clear');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings berhasil diupdate!');
    }

    /**
     * Delete analytics credentials
     */
    public function deleteAnalyticsCredentials()
    {
        Setting::where('key', 'ga_credentials_json')->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Analytics credentials deleted successfully!');
    }

    /**
     * Test Google Analytics credentials
     */
    public function testAnalyticsCredentials()
    {
        try {
            $service = new \App\Services\GoogleAnalyticsService();
            
            // Check if configured
            if (!$service->isConfigured()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google Analytics belum dikonfigurasi. Pastikan Property ID dan Credentials sudah diisi.',
                    'details' => [
                        'property_id' => Setting::where('key', 'ga_property_id')->exists() ? 'Set' : 'Not Set',
                        'credentials' => Setting::where('key', 'ga_credentials_json')->exists() ? 'Set' : 'Not Set',
                    ]
                ], 400);
            }
            
            // Test API call
            $period = \Spatie\Analytics\Period::days(7);
            $visitors = $service->getTotalVisitors($period);
            $pageViews = $service->getPageViews($period);
            
            return response()->json([
                'success' => true,
                'message' => 'Koneksi berhasil! Google Analytics API bekerja dengan baik.',
                'data' => [
                    'visitors_7_days' => $visitors,
                    'page_views_7_days' => $pageViews,
                    'property_id' => Setting::where('key', 'ga_property_id')->value('value'),
                    'service_account' => json_decode(Setting::where('key', 'ga_credentials_json')->value('value'), true)['client_email'] ?? 'Unknown',
                ]
            ]);
            
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $suggestions = [];
            
            // Provide helpful suggestions based on error
            if (strpos($errorMessage, 'User does not have') !== false) {
                $suggestions[] = 'Service account belum ditambahkan ke GA4 property';
                $suggestions[] = 'Atau role yang diberikan tidak cukup (minimal Viewer)';
            } elseif (strpos($errorMessage, 'Property') !== false && strpos($errorMessage, 'not found') !== false) {
                $suggestions[] = 'Property ID salah atau tidak ditemukan';
                $suggestions[] = 'Cek Property ID di Google Analytics Admin';
            } elseif (strpos($errorMessage, 'credentials') !== false) {
                $suggestions[] = 'Credentials JSON tidak valid';
                $suggestions[] = 'Download ulang dari Google Cloud Console';
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Koneksi gagal: ' . $errorMessage,
                'suggestions' => $suggestions,
                'property_id' => Setting::where('key', 'ga_property_id')->value('value'),
            ], 400);
        }
    }
}