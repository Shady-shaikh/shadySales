<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Company::all();
        return view('backend.company.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.company.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'address_line_1' => 'required',
            'landmark' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'city_name' => 'required',
            'pin_code' => 'required',
            'gst_no' => 'required',
        ]);

        $model = new Company();
        $model->fill($request->all());

        if (!empty($request->company_logo)) {
            $imageName = upload_pic($request->company_logo, 'company_profile');
            $model->company_logo = $imageName;
        }


        if ($model->save()) {
            return redirect()->route('company.index')->with('success', 'Company added successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Company::find($id);
        return view('backend.company.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Company::find($id);
        return view('backend.company.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $model = Company::findorFail($id);
        $model->fill($request->all());

        if (!empty($request->company_logo)) {
            $imageName = upload_pic($request->company_logo, 'company_profile');
            $model->company_logo = $imageName;
        }

        
        if ($model->save()) {
            return redirect()->route('company.index')->with('success', 'Company updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Company::findOrFail($id);
        $permission->delete();
        return redirect()->route('company.index')->with('success', 'Company deleted successfully');
    }

    public function country_state_city()
    {
        $result = [];
        if (isset($_POST["country_id"])) {
            //Get all state data
            $country_id = $_POST['country_id'];
            $states = DB::table('states')->where('country_id', $country_id)->pluck('state_name', 'state_id');
            $result['states'] = json_encode($states);
        }

        if (isset($_POST["state_id"])) {
            $state_id = $_POST['state_id'];
            //Get all city data
            $cities = DB::table('cities')->where('state_id', $state_id)->pluck('city_name', 'city_id');
            $result['cities'] = json_encode($cities);
        }

        return $result;
    }
}
