<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function show(Request $request){
        $data=Role::find($request->role);
        return $data->employees;
    }


    public function store(Request $request){
        $data=$request->only('role');
        $result=Role::create($data);
        if($result){
            return response()->json([
                'success'=>true,
                'data'=>$data
            ]);
        }
    }
}
