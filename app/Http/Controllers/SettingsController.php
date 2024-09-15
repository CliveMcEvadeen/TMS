<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\SettingsFormRequest;

class SettingsController extends Controller
{
    public function index(){

        $this->authorize('view_settings', Settings::class);

        $settings = Settings::get()->keyBy('key');

        return view('admin.settings',[
            'title' => 'General Settings',
            'settings' => $settings
        ]);
    }

    public function update(SettingsFormRequest $request){

        $this->authorize('update_settings', Settings::class);
        
        $request->validated();
        
        Settings::where('id',$request->site_sys_name_id)->update(['value' => $request->site_sys_name]);
        Settings::where('id',$request->site_name_id)->update(['value' => $request->site_name]);
        Settings::where('id',$request->site_email_id)->update(['value' => $request->site_email]);
        Settings::where('id',$request->site_contact_id)->update(['value' => $request->site_contact]);
        Settings::where('id',$request->site_address_id)->update(['value' => $request->site_address]);

        if($request->hasFile('site_logo')){
            $logo = $request->file('site_logo')->store('settings','public');
            Settings::findorFail($request->site_logo_id)->update(['value' => $logo]);
        }
        if($request->hasFile('site_logo2')){
            $logo2 = $request->file('site_logo2')->store('settings','public');
            Settings::findorFail($request->site_logo2_id)->update(['value' => $logo2]);
        }

        return redirect()->back()->with('success','Setting has been changed!');
    }
}