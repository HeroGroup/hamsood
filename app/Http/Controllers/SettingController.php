<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller
{
    public function getSettings()
    {
        $setting = Setting::first();
        return view('admin.settings', compact('setting'));
    }

    public function postSettings(Request $request)
    {
        try {
            if ($request->id) {
                $setting = Setting::find($request->id);
                $setting->update($request->all());
            }
        } catch(Exception $exception) {
            //
        } finally {
            return redirect(route('settings'));
        }
    }
}
