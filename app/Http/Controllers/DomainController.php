<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            $request->validate([
                'domain_name' => 'required|unique:domains,domain_name,' . $request->user->id . ',id,deleted_at,NULL|max:255',
            ], [
                'domain_name.required' => 'Please enter domain name'
            ]);
            $result = Domain::create([
                'domain_name' => $request->domain_name,
                'admin_id' => $request->user->id
            ]);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'data' => $result
                ], 200);
            }
        } catch (ValidationException $th) {
            $errors = $th->errors();
            $message = "";
            foreach ($errors as $field => $messages) {
                $message = $messages[0];
            }
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Domain $domain)
    {
        $data = Domain::all();
        return response()->json([
            'success' => true,
            'domains' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domain $domain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $domainId)
    {
        try {
            $request->validate([
                'domain_name' => 'required|unique:domains,domain_name,' . $domainId . ',id,deleted_at,NULL|max:255',
            ], [
                'domain_name.required' => 'Please enter domain name'
            ]);

            $result = Domain::find($domainId)->update([
                'domain_name' => $request->domain_name,
                'admin_id' => $request->user->id,
            ]);
            if ($result) {
                return response()->json([
                    'success' => true,
                    'data' => $result,
                ], 200);
            }
        } catch (ValidationException $th) {
            $errors = $th->errors();
            $message = "";
            foreach ($errors as $field => $messages) {
                $message = $messages[0];
            }
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $domainId)
    {
        $result = Domain::find($domainId)->delete();
        if ($result) {
            return response()->json([
                'success' => true,
                'message' => "Domain deleted successfully",
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Something went wrong",
        ], 422);
    }
}
