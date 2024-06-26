<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
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
        try {
            $validatedData = $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8',
                    'teacher_name' => 'required|string'
                ],
                [
                    'name.required' => 'The name field is required.',
                    'name.string' => 'The name must be a string.',
                    'name.max' => 'The name may not be greater than :max characters.',
                    'email.required' => 'The email field is required.',
                    'email.string' => 'The email must be a string.',
                    'email.email' => 'The email must be a valid email address.',
                    'email.max' => 'The email may not be greater than :max characters.',
                    'email.unique' => 'The email has already been taken.',
                    'password.required' => 'The password field is required.',
                    'password.string' => 'The password must be a string.',
                    'password.min' => 'The password must be at least :min characters.',
                    'teacher_name.required' => 'The favourite teacher"s name field is required.',
                    'teacher_name.string' => 'The favourite teacher"s name must be a string.',
                ]
            );
            $validatedData['password'] = Hash::make($request->password);
            // return $validatedData['name'];
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'teacher_name' => $validatedData['teacher_name'],
            ]);
            // $user->profile()->create([
            //     'bio'=>$request['bio'],
            //     'gender'=>$request['gender'],

            // ]);


            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'user created sucessfully ',
                    'data' => $user
                ], 200);
            }
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->validator->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $req)
    {
        // $users_list = User::with('profile')->get();


        // $users_list = User::withWhereHas('profile',function($query){
        //     $query->where('gender','Female');
        // })->get();

        $users_list = User::all();


        return response()->json([
            'success' => true,
            'data' => $users_list,
        ], 200);
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
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $validatedData = $request->validate(
                [
                    'name' => 'sometimes|string|max:255',
                    'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
                    'password' => 'sometimes|string|min:8'
                ],
                [
                    'name.required' => 'The name field is required.',
                    'name.string' => 'The name must be a string.',
                    'name.max' => 'The name may not be greater than :max characters.',
                    'email.required' => 'The email field is required.',
                    'email.string' => 'The email must be a string.',
                    'email.email' => 'The email must be a valid email address.',
                    'email.max' => 'The email may not be greater than :max characters.',
                    'email.unique' => 'The email has already been taken.',
                    'password.required' => 'The password field is required.',
                    'password.string' => 'The password must be a string.',
                    'password.min' => 'The password must be at least :min characters.',
                ]
            );
            if ($request->has('password')) {
                $validatedData['password'] = Hash::make($request->password);
            } else {
                unset($validatedData['password']);
            }
            $user->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->validator->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function adminCheck(Request $request)
    {
        return response()->json([
            "ok" => true
        ], 200);
    }
    public function roleChange(Request $request, int $userID)
    {
        $user = User::find($userID);
        if ($user) {
            $user->role = $request->role;
            $user->save();

            return response()->json(['success'=>true,'message' => 'Role updated successfully'],200);
        } else {
            return response()->json(['success'=>false,'error' => 'User not found'], 404);
        }
    }
}
