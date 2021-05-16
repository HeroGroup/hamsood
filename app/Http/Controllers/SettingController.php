<?php

namespace App\Http\Controllers;

use App\SupportingArea;
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

    public function supportingAreas()
    {
        $areas = SupportingArea::orderBy('id')->get();
        return view('admin.supportingAreas.index', compact('areas'));
    }


    public function storeSupportingArea(Request $request)
    {
        try {
            SupportingArea::create([
                'supporting_area' => $request->supporting_area
            ]);
            return back()->with('message', 'منطقه جدید با موفقیت ثبت شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function updateSupportingArea(Request $request, SupportingArea $area)
    {
        try {
            $area->update($request->all());
            return back()->with('message', 'به روز رسانی با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function removeSupportingArea(SupportingArea $area)
    {
        try {
            $area->delete();
            return back()->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }
}
