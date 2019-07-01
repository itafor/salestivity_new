<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

use App\Role;
use App\Department;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        
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
    public function destroy(User  $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }

    public function indexSubusers()
    {
        $userId = auth()->user()->id;
        $allUsers = User::where('profile_id', '=', $userId);
        return view('users.index', ['allusers' => $allUsers->paginate(15)]);
    }
    
    public function createsubuser()
    {
        $userId = auth()->user()->id;
        $roles = Role::where('main_acct_id', $userId)->get();
        $departments = Department::where('main_acct_id', $userId)->get()->unique('name')->values()->all();
        $reportsTo = User::where('profile_id', $userId)->get();
        return view('users.create', compact('roles', 'departments', 'reportsTo'));
    }
    
    public function storesubuser(Request $request)
    {
        $userId = auth()->user()->id;

        $user = new User;
        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        // dd($user);
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->department_id = $request->department_id;
        $user->unit_id = $request->unit_id;
        $user->reports_to = $request->report;
        $user->status = $request->status;
        $user->profile_id = $userId;
        $user->password = Hash::make($request->get('password'));
        // dd($user);
        // $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('allSubUsers')->withStatus(__('User successfully created.'));


    }
}
