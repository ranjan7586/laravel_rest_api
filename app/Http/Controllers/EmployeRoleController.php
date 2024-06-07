<?php

namespace App\Http\Controllers;

use App\Models\Employe_Role;
use Illuminate\Http\Request;

class EmployeRoleController extends Controller
{
    public function store(Request $request)
    {
        $data=$request->only('employe_id','role_id');
        $result=Employe_Role::create($data);
        if($result){
            return response()->json([
                "success"=>true,
                "data"=>$result
            ]);
        }
    }
}
