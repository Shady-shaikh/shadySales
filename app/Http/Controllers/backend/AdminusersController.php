<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Adminusers;
use App\Models\backend\BasePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AdminusersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Adminusers::get();
        return view('backend.adminusers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.adminusers.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'role_id' => 'required',
            'mobile_no' => 'min:10',
            'email' => 'required|email|unique:admin_users,email',
            'role_id' => 'required',
            'password' => 'required|confirmed|min:6',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $user = new AdminUsers;
        $user->password = bcrypt($request->password);
        $user->fill($request->all());
        if (!empty($request->profile_pic)) {
            $imageName = time() . '.' . $request->profile_pic->extension();
            if (!file_exists(public_path('admin_user_profile'))) {
                mkdir(public_path('admin_user_profile'), 0777);
            }
            $request->profile_pic->move(public_path('admin_user_profile'), $imageName);
            $user->profile_pic = $imageName;
        }

        $user->save();

        $role = Role::findOrFail($request->input('role_id'));
        $user->assignRole($role);


        return redirect('/admin/users')->with('success', 'New User Registered');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Adminusers::find($id);
        return view('backend.users.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Adminusers::find($id);
        return view('backend.adminusers.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required',
            'role_id' => 'required',
            'mobile_no' => 'min:10',
            'email' => 'required|email|unique:admin_users,email,' . $id . '',
            'role_id' => 'required',
            'password' => 'nullable|confirmed|min:6',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $user = AdminUsers::find($id);
        $user->password = bcrypt($request->password);
        $user->fill($request->all());

        if (!empty($request->profile_pic)) {
            $imageName = upload_pic($request->profile_pic,'admin_user_profile');
            $user->profile_pic = $imageName;
        }

        $user->save();

        $role = Role::findOrFail($request->input('role_id'));
        $user->assignRole($role);


        return redirect('/admin/users')->with('success', 'User Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = AdminUsers::findOrFail($id);
        $permission->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
