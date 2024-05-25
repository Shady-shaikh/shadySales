<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::all();
        return view('backend.role.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.role.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => ['required', 'unique:roles,name']
        ]);

        $menu_ids = ($request->input('menu_id')) ? implode(',', $request->input('menu_id')) : NULL;
        $submenu_ids = ($request->input('submenu_id')) ? implode(',', $request->input('submenu_id')) : NULL;

        $already_exists = Role::where('department_id', $request->input('name'))->first();
        if (!empty($already_exists)) {
            return redirect()->back()->with('error', 'Role Already Added!');
        }

        $departments = DB::table('deapartment')->where('id', $request->input('name'))->pluck('name', 'id')->toArray();

        $role = Role::create([
            'name' =>  $departments[$request->input('name')], 'menu_ids' => $menu_ids, 'parent_roles' => $request->input('parent_roles') ?? null, 'submenu_ids' => $submenu_ids, 'readonly' => $request->readonly ?? null, 'readwrite' => $request->readwrite ?? null
        ]);
        $role->department_id = $request->input('name');
        $role->save();

        // $role->givePermissionTo($request->input('permissions'));

        $numericPermissionArray = [];
        foreach ($request->permissions as $permission) {
            $numericPermissionArray[] = intval($permission);
        }

        $role->syncPermissions($numericPermissionArray);

        return redirect()->route('role.index')->with('success', 'New Role Added!');
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
        $data = Role::find($id);
        $has_permissions = $data->getAllPermissions();
        $has_permissions = collect($has_permissions)->mapWithKeys(function ($item, $key) {
            return [$item['id'] => $item['id']];
        })->toArray();
        return view('backend.role.form', compact('data', 'has_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $already_exists = Role::where('id', '!=', $id)->where('department_id', $request->input('name'))->first();
        if (!empty($already_exists)) {
            return redirect()->back()->with('error', 'Role Already Added!');
        }

        $departments = DB::table('deapartment')->where('id', $request->input('name'))->pluck('name', 'id')->toArray();

        $role = Role::findOrFail($id);
        $role->name = $departments[$request->input('name')] ?? 'Super Admin';
        $role->department_id = $request->input('name') ?? 1;
        $role->parent_roles = $request->input('parent_roles');
        $role->menu_ids = ($request->input('menu_id')) ? implode(',', $request->input('menu_id')) : NULL;
        $role->submenu_ids = ($request->input('submenu_id')) ? implode(',', $request->input('submenu_id')) : NULL;
        $role->readonly = $request->input('readonly') ?? null;
        $role->readwrite = $request->input('readwrite') ?? null;
        $role->update();

        // $role->givePermissionTo($request->input('permissions'));

        $numericPermissionArray = [];
        foreach ($request->permissions as $permission) {
            $numericPermissionArray[] = intval($permission);
        }

        $role->syncPermissions($numericPermissionArray);

        return redirect()->route('role.index')->with('success', 'New Role Added!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully');
    }
}
