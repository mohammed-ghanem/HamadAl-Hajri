<?php

namespace App\Http\Controllers\WebController;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Setting $model)
    {
        if ($model->all()->count() > 0) {
            
            $model = Setting::find(1);
        }

        return view('admin.settings.index' ,compact('model') , ['title' => trans('admin/settings/index.title')]);
    }

   

    public function update(Request $request, $id)
    {
       $data = $this->validate($request,
        [
       
		'logo'                  =>validateImage(),
		'icon'                  =>validateImage(),
		'email'                 =>'nullable|email',
		'phone'                 =>'nullable',
        'instagram_url'         =>'url|nullable',
        'facebook_url'          =>'url|nullable',
        'youtube_url'           =>'url|nullable',
		'twitter_url'           =>'url|nullable',
        'telegram_url'          =>'url|nullable',
        'blog'                  =>'url|nullable',
        'about_sheikh'          =>'nullable',
        'siteName'              =>'nullable',
        'keywords'              =>'nullable',
        'description'           =>'nullable',
        'status'                =>'',
        'message_maintenance'   =>'nullable',
        'main_languge'          =>'',
        'site_right'             =>'nullable',

        ],[],
        [
            'logo' => trans('admin/settings/index.logo'),
            'icon' => trans('admin/settings/index.icon'), 
            
        ]);
       

        if(request()->hasFile('logo'))
        {
            $data['logo'] = up()->upload(
             [
               // 'new_name' => '',
                'file' => 'logo',
                'path' => 'settings',
                'upload_file' => 'single',
                'delete_file' =>setting()->logo, 
                
                
            ]);
            
        }
        
        if(request()->hasFile('icon'))
        {
            $data['icon'] = up()->upload(
                [
                  // 'new_name' => '',
                   'file'          => 'icon',
                   'path'          => 'settings',
                   'upload_file'   => 'single',
                   'delete_file'   =>setting()->icon, 
                   
                   
               ]);
            
        }

        
        
    

        if (Setting::all()->count() > 0) {
           
            Setting::orderBy('id', 'desc')->update($data);
                
        } else {
            Setting::create($request->all());
        }
        
         session()->flash('success', trans('admin/settings/index.update_record'));
        
         return redirect(adminUrl('settings'));
        
    }

  
}