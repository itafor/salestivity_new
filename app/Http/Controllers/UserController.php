<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\UserRequest;
use App\Mail\SendSubuserEmailVerificationLink;
use App\Role;
use App\SubUser;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;

class UserController extends Controller
{

      public function __construct()
    {
        $this->middleware(['auth','verified','subuserVerified'])->except(['resendSubuserEmailEmailVerification','verifySubuserEmail','subUserEmailverified']);
    }

    public function verifySubuserEmail()
    {
        return view('auth.verifySubuser');
    }

    public function resendSubuserEmailEmailVerification(){

       $subuser =  Auth::guard('sub_user')->user();

       $toEmail = $subuser->email;

      Mail::to($toEmail)->send(new SendSubuserEmailVerificationLink($subuser));

      session(['emailResent' => 'resentToSubuser']);

        return redirect()->route('subuser.verify.email');

    }

     public function subUserEmailverified()
    {
       $subuserId = Auth::guard('sub_user')->user()->id;
      
        $subuser = SubUser::where('id',$subuserId)->first();
        $subuser->email_verified_at = Carbon::now();
        $subuser->save();

        return redirect()->route('home');
    }
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        // return view('users.index', ['users' => $model->paginate(15)]);
        $userId = auth()->user()->id;
        $allUsers = User::where('profile_id', '=', $userId);
        return view('users.index', ['allusers' => $allUsers->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $userId = auth()->user()->id;
        $roles = Role::where('main_acct_id', $userId)->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());
        // dd($model);
        // // update profile with a profile_id
        // $userId = $model->id;
        // $model->profile_id = $userId;
        // $model->update();

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // set a user to disabled and delete user
        $user->status = 0;
        $user->update();
        // dd($user);
        $user->delete();
        

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }

    public function indexSubusers()
    {
        $userId = \getActiveGuardType()->main_acct_id;
        // dd($userId);
        
        $allUsers = SubUser::where('main_acct_id', '=', $userId);
        return view('users.index', ['allusers' => $allUsers->paginate(15)]);
    }
    
    public function createsubuser()
    {
        $userId = \getActiveGuardType()->main_acct_id;
        // $roles = Role::where('main_acct_id', $userId)->get();
        $roles = Role::all();
        $departments = Department::where('main_acct_id', $userId)->get()->unique('name')->values()->all();
        $reportsTo = SubUser::where('main_acct_id', $userId)->get();
        // dd($reportsTo);
        return view('users.create', compact('roles', 'departments', 'reportsTo'));
    }
    
    public function storesubuser(Request $request)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $guard_object = \getActiveGuardType();
        $input = $request->all();
        $rules = [
            
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:sub_users',
        ];
        $message = [
            'name.required' => 'Please input Your First name',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
       
       $validate_Level = $this->validateLevel($request->report, $request->level);
       if($validate_Level){
        return $validate_Level;
       }

            $user = new SubUser;
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->created_by = $guard_object->created_by;
            $user->user_type = $guard_object->user_type;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->level = $request->level;
            $user->reports_to = $request->report;
            $user->status = $request->status;
            $user->main_acct_id = $userId;
            $user->password = Hash::make($request->get('password'));
            // dd($user);
            // $user->password = bcrypt($request->password);
            $user->save();

            $toEmail = $user->email;
            
          Mail::to($toEmail)->send(new SendSubuserEmailVerificationLink($user));

            Alert::success('User','User successfully created.');
            return redirect()->route('allSubUsers');
        

        
    }


    /**
     * Edit a sub user
     */
    public function editSubUser(Request $request, $id)
    {
        $userId = \getActiveGuardType()->main_acct_id;
        $user = SubUser::find($id);
        $roles = Role::all();
        $departments = Department::where('main_acct_id', $userId)->get()->unique('name')->values()->all();
        $reportsTo = SubUser::where('main_acct_id', $userId)->get();
       // dd($reportsTo);

        // dd($reportsTo);


        return view('users.editSubUser', compact('roles', 'departments', 'reportsTo', 'user'));
    }

    public function updateSubUser(Request $request, $id)
    {

      $validate_Level = $this->validateLevel($request->report, $request->level);
       if($validate_Level){
        return $validate_Level;
       }

        $user = SubUser::find($id);
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->role_id = $request->input('role_id');
        $user->level = $request->input('level');
        $user->reports_to = $request->input('report');
        $user->status = $request->input('status');
        
        $user->update();
        
        return redirect()->route('allSubUsers')->withStatus(__('User successfully updated.'));
    }

    public function deleteSubUSer($id)
    {
        $id = \decrypt($id);
        
        try {
            $user = SubUser::find($id);
            if($user)
            {
               // set a user to disabled and delete user
                $user->status = 0;
                $user->update();
                // dd($user);
                $user->delete();
                return redirect()->route('allSubUsers')->withStatus(__('User successfully deleted.'));
            }  

        } catch (\Throwable $th) {
            return redirect()->route('allSubUsers')->withStatus(__('Unable to complete transaction.'));
        }


    }

    public function validateLevel($userId, $level) {
        $userToReportTo = SubUser::where([
        ['id', $userId],
        ['level','!=',null]
      ])->first();
       //dd($userToReportTo);
         if ($userToReportTo == null) {
          return redirect()->back()->withStatus(__('The selected  user to be reported to has not been assigned to a level!'));
                }
           if ($userToReportTo && $userToReportTo->level >= $level) {
          return redirect()->back()->withInput()->withStatus(__('A user can only report to another user with a lower level number i.e 2 can report to 1!'));
            }
    }
}
