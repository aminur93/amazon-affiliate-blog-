<?php

namespace App\Http\Controllers\Author;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function index()
    {
        return view('author.settings');
    }
    
    public function profileUpdate(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email'=> 'required|email',
            'image'=> 'required|image'
        ]);
        
        $image = $request->file('image');
        $slug = str_slug($request->name);
        
        $user = User::findOrFail(Auth::id());
        
        if (isset($image))
        {
            $current_date = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$current_date.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('profile'))
            {
                Storage::disk('public')->makeDirectory('profile');
            }
            
            //delete old image from disk
            
            if (Storage::disk('public')->exists('profile/'.$user->image))
            {
                Storage::disk('public')->delete('profile/'.$user->image);
            }
            
            $profile = Image::make($image)->resize(500,500)->stream();
            Storage::disk('public')->put('profile/'.$imageName,$profile);
        }else{
            $imageName = $user->image;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        
        $user->save();
        
        Toastr::success('Profile Update Successfully :)','success');
        return redirect()->back();
        
    }
    
    public function passwordUpdate(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password,$hashedPassword))
        {
            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Change Successfully','success');
                Auth::logout();
                return redirect()->back();
            }else{
                Toastr::error('New password can not be same old password','error');
                return redirect()->back();
            }
        }else{
            Toastr::error('Current password does not Match','error');
            return redirect()->back();
        }
    }
}
