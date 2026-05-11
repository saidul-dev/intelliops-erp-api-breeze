<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::get();
        return response()->json($settings);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'required|image|max:2048',
            'site_favicon' => 'required|image|max:2048',
            'site_description' => 'required|string',
            'site_keywords' => 'nullable|string',
            'site_author' => 'nullable|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
        ]);

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
