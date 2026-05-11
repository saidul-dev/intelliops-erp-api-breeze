<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->mapWithKeys(function ($setting) {
            if (in_array($setting->key, ['site_logo', 'site_favicon']) && $setting->value) {
                return [$setting->key => asset('storage/' . $setting->value)];
            }
            return [$setting->key => $setting->value];
        });
        return response()->json($settings);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:2048',
            'site_description' => 'required|string',
            'site_keywords' => 'nullable|string',
            'site_author' => 'nullable|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
        ]);

        // Handle file uploads for logo and favicon
        if ($request->hasFile('site_logo')) {
            $validatedData['site_logo'] = $request->file('site_logo')->store('site_settings', 'public');
        }

        if ($request->hasFile('site_favicon')) {
            $validatedData['site_favicon'] = $request->file('site_favicon')->store('site_settings', 'public');
        }

        foreach ($validatedData as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return response()->json([
            'message' => 'Site settings updated successfully',
            'data' => $validatedData,
        ]);
    }
}
