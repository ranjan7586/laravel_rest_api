<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        try {
            $result = Profile::create($request->all());
            if ($result) {
                return response()->json([
                    "success" => true,
                    "message" => "Record created successfully",
                    'data' => $result
                ], 200);
            } else {
                return response()->json(([
                    "success" => false,
                    "message" => "Something went wrong"
                ]), 400);
            }
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->validator->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data=Profile::with('user')->get();
        return response()->json([
            "success"=>true,
            "data"=>$data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
