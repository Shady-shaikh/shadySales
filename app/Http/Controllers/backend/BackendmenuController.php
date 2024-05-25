<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\BackendMenubar;
use App\Models\backend\BackendSubMenubar;
use App\Models\backend\BasePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;


class BackendmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BackendMenubar::all();
        return view('backend.backendmenu.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.backendmenu.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'menu_name' => ['required'],
            'menu_controller_name' => ['required'],
            'permissions' => ['required_if:has_submenu,==,0'],
        ]);
        $backendmenu = new BackendMenubar();
        $backendmenu->fill($request->all());
        if ($request->has_submenu == '0') {
            $backendmenu->permissions = ($request->permissions != '') ? implode(',', $request->permissions) : NULL;
        } else {
            $backendmenu->permissions = NULL;
        }
        if ($backendmenu->save()) {
            if ($backendmenu->permissions) {
                $base_permissions = BasePermission::all();
                foreach ($base_permissions as $permission) {
                    if (in_array($permission->base_permission_id, $request->permissions)) {

                        $menu_permissions = Permission::where('base_permission_id', $permission->base_permission_id)->where('menu_id', $backendmenu->menu_id)->where('submenu_id', $backendmenu->submenu_id)->first(); //Match input //permission to db record
                        $permission_name = $permission->base_permission_name . ' ' . $request->input('menu_name');
                        $ex_permission = Permission::where('name', $permission_name)->first();
                        if (isset($menu_permissions)) {
                            Permission::where('id', $menu_permissions->id)->update(['name' => $permission_name, 'base_permission_id' => $permission->base_permission_id, 'base_permission_name' => $permission->base_permission_name, 'menu_id' => $backendmenu->menu_id, 'submenu_id' => $backendmenu->submenu_id]);
                        } else {
                            if ($ex_permission) {
                                $permission_name = $permission->base_permission_name . ' ' . $request->input('menu_name') . ' ' . $backendmenu->menu_id;
                            }
                            Permission::create(['name' => $permission_name, 'base_permission_id' => $permission->base_permission_id, 'base_permission_name' => $permission->base_permission_name, 'menu_id' => $backendmenu->menu_id, 'submenu_id' => $backendmenu->submenu_id]);
                        }
                    } else {
                        $menu_permissions = Permission::where('base_permission_id', $permission->base_permission_id)->where('menu_id', $backendmenu->menu_id)->where('submenu_id', $backendmenu->submenu_id)->first(); //Match input //permission to db record
                        if ($menu_permissions) {
                            $menu_permissions->delete();
                        }
                    }
                }
            }
        }

        Session::flash('message', 'Menu added!');
        Session::flash('status', 'success');

        return redirect('admin/backendmenu');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BackendMenubar::find($id);
        return view('backend.backendmenu.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'menu_name' => ['required'],
            'menu_controller_name' => ['required'],
            'permissions' => ['required_if:has_submenu,==,0'],
        ]);

        $backendmenu = BackendMenubar::findOrFail($id);
        $backendmenu->fill($request->all());
        if ($request->has_submenu == '0') {
            $backendmenu->permissions = ($request->permissions != '') ? implode(',', $request->permissions) : NULL;
            if ($request->permissions) {
                $base_permissions = BasePermission::all();
                foreach ($base_permissions as $permission) {
                    if (in_array($permission->base_permission_id, $request->permissions)) {

                        $permission_name = $permission->base_permission_name . ' ' . $request->input('menu_name');

                        $menu_permissions = Permission::where('name', $permission_name)->first(); //Match input //permission to db record
                        if ($menu_permissions) {
                            Permission::where('id', $menu_permissions->id)->update(['name' => $permission_name, 'base_permission_id' => $permission->base_permission_id, 'base_permission_name' => $permission->base_permission_name, 'menu_id' => $request->menu_id, 'submenu_id' => $request->submenu_id]);
                        } else {
                            Permission::create(['name' => $permission_name, 'base_permission_id' => $permission->base_permission_id, 'base_permission_name' => $permission->base_permission_name, 'menu_id' => $request->menu_id, 'submenu_id' => $request->submenu_id]);
                        }
                    } else {
                        $menu_permissions = Permission::where('base_permission_id', $permission->base_permission_id)->where('menu_id', $request->menu_id)->where('submenu_id', $request->submenu_id)->first(); //Match input //permission to db record
                        if ($menu_permissions) {
                            $menu_permissions->delete();
                        }
                    }
                }
            }
        } else {
            $backendmenu->permissions = NULL;
            $menu_permissions = Permission::where('menu_id', $request->menu_id)->where('submenu_id', $request->submenu_id)->get(); //Match input //permission to db record
            $menu_permissions->each->delete();
        }
        if ($backendmenu->update()) {
        }
        Session::flash('message', 'Menu updated!');
        Session::flash('status', 'success');

        return redirect('admin/backendmenu');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $backendmenu = BackendMenubar::findOrFail($id);

        $backendsubmenu = BackendSubMenubar::where('menu_id',$id)->get();
        $backendsubmenu->each->delete();
        
        $menu_permissions = Permission::where('menu_id', $id)->get(); //Match input //permission to db record
        $menu_permissions->each->delete();
        $backendmenu->delete();
        Session::flash('message', 'Menu deleted!');
        Session::flash('status', 'success');

        return redirect('admin/backendmenu');
    }
}
