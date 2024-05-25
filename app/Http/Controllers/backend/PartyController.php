<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Party;
use Illuminate\Http\Request;


class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Party::all();
        return view('backend.party.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.party.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:party,name',
            'company_id' => 'required',
            'type' => 'required',
            'category' => 'required',
            'group' => 'required',
            'building' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'city_name' => 'required',
            'pin_code' => 'required',
        ]);

        $model = new Party();
        $model->fill($request->all());

        if ($model->save()) {
            return redirect()->route('party.index')->with('success', 'Party added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Party::find($id);
        return view('backend.permission.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Party::find($id);
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

        $model = Party::findorFail($id);
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
        $permission = Party::findOrFail($id);
        $permission->delete();
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully');
    }
}
