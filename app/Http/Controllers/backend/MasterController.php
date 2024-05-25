<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\backend\Category;
use App\Models\backend\Group;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function store_category(Request $request)
    {
        $model = new Category();
        $model->name = $request->data_name[0];
        $model->save();

        $data = Category::pluck('name', 'id');
        $data_options = "";
        foreach ($data as $key => $val) {
            if ($key == $model->id) {
                $data_options .= '<option value="' . $key . '" selected>' . $val . '</option>';
            } else {
                $data_options .= '<option value="' . $key . '">' . $val . '</option>';
            }
        }
        return ['flag' => 'success', 'message' => 'New Category Added!', 'data' => $data_options];
    }

    public function store_group(Request $request)
    {
        $model = new Group();
        $model->category_id = $request->data_name[0];
        $model->name = $request->data_name[1];
        $model->save();

        $data = Group::where('category_id', $model->category_id)->pluck('name', 'id');
        $data_options = "";
        foreach ($data as $key => $val) {
            if ($key == $model->id) {
                $data_options .= '<option value="' . $key . '" selected>' . $val . '</option>';
            } else {
                $data_options .= '<option value="' . $key . '">' . $val . '</option>';
            }
        }
        return ['flag' => 'success', 'message' => 'New Group Added!', 'data' => $data_options];
    }

    public function get_group(Request $request)
    {
        $id = $request->input('id');
        $data = Group::where(['category_id' => $id])->pluck('name', 'id');

        return response()->json($data);
    }

    public function get_category(Request $request)
    {
        $id = $request->input('id');
        $data = Category::where(['id' => $id])->pluck('name', 'id');

        return response()->json($data);
    }
}
