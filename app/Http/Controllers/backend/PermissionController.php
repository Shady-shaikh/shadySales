<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\BasePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BasePermission::all();
        return view('backend.permission.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.permission.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'base_permission_name' => 'required|unique:base_permissions,base_permission_name',
        ]);

        $model = new BasePermission();
        $model->guard_name  = Auth::guard('admin')->name;
        $model->fill($request->all());

        if ($model->save()) {
            return redirect()->route('permission.index')->with('success', 'Permission added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BasePermission::find($id);
        return view('backend.permission.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BasePermission::find($id);
        return view('backend.permission.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'base_permission_name' => 'required',
        ]);

        $model = BasePermission::findorFail($id);
        $model->guard_name  = Auth::guard('admin')->name;
        $model->fill($request->all());

        if ($model->save()) {
            return redirect()->route('permission.index')->with('success', 'Permission updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = BasePermission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully');
    }
}
