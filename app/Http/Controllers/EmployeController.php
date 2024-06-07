<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function show()
    {
        $data = Employee::find(3);

        return $data->roles;
    }


    public function store(Request $request)
    {
        $data=$request->only('name');
        $result=Employee::create($data);
        if($result){
            return response()->json([
                "success"=>true,
                "data"=>$result
            ]);
        }
    }
}
