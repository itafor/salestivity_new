<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Rules\CurrentPasswordCheckRule;
use App\SubUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
       
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'user_id' => 'required',
            'last_name' => 'required',
        ]);
        // dd($request->all());

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }
        if(getActiveGuardType()->user_type == 'sub_users'){
           $sub_user = SubUser::findOrFail($request->user_id);
           $sub_user->name = $request->name;
           $sub_user->last_name = $request->last_name;
           $sub_user->phone = isset($request->phone) ? $request->phone : null;
           $sub_user->save();
        return redirect()->back()->withStatus(__('Profile successfully updated.'));
        }

        auth()->user()->update($request->all());

        // return redirect()->back()->withStatus(__('Profile successfully updated.'));
        return redirect()->back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(Request $request)
    {
          $validator = Validator::make($request->all(),[
            'old_password' => ['required', 'min:6', new CurrentPasswordCheckRule],
            'password' => ['required', 'min:6', 'confirmed', 'different:old_password'],
            'password_confirmation' => ['required', 'min:6'],
        ]);
        // dd($request->all());

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }
        
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
