<?php

namespace App\Http\Controllers\FrontendController\Authentcation;

use App\Models\Client;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function registrationForm()
    {
        $visitors = Visitor::orderBy('id','desc')->first();
        $visitors->increment('visitor_count');
        
        return view('frontend.auth.register',compact('visitors'));
    }

    public function do_register(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name'               => 'required',
            'email'              =>'required|email|unique:clients',
            'password'           =>'required|confirmed'
            
        ]);

        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        $request->merge(['password'=>bcrypt($request->password)]);

        $client = Client::create($request->all());
        $client->save();
       
        $request->session()->put('data',$request->input());

                  return redirect()->route('frontend.index')->with([
                'message'    => 'تم انشاء الحساب بنجاح',
                'alert-type'=>'success'
            ]);
           
            }
           
       

        

       
          
            
        
    }