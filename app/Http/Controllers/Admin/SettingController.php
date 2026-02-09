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
        ]);

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

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings berhasil diupdate!');
    }
}