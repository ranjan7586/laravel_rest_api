<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image=$request->file('image');
        $note=$request->file('note_content');
        $imageFileName=time().'__'.$image->getClientOriginalName();
        $noteFileName=time().'__'.$note->getClientOriginalName();
        $imagePath=$image->storeAs('note-images',$imageFileName,'public');
        $notePath=$note->storeAs('notes',$noteFileName,'public');
        $domain_name=Domain::find($request->domain_id)->domain_name;
        $result=Note::create([
            'name'=>$request->name,
            'author'=>$request->author,
            'description'=>$request->description,
            'image'=>$imagePath,
            'note_content'=>$notePath,
            'admin_id'=>$request->user->id,
            'domain_id'=>$request->domain_id,
            'domain_name'=>$domain_name,
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Note Created Successfully',
            'data'=>$result,
            'basename'=>basename($imagePath)
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $result=Note::all();
        return response()->json([
            'success'=>true,
            'data'=>$result,
        ],200);
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
    public function noteImage(int $id){
        $path=basename(Note::find($id)->image);
        $url = url('storage/note-images/' . $path);
        return response()->json([
            'success'=>true,
            'url' => env('APP_URL').'/storage/note-images/'.$path,
        ],200);

    }

        public function checkClientIp(Request $request)
    {
        $ipAddress = 'UNKNOWN';
    
        // Prioritize checking for known proxy headers
        if ($request->server('HTTP_X_FORWARDED_FOR')) {
            $ipAddresses = explode(',', $request->server('HTTP_X_FORWARDED_FOR'));
            $ipAddress = trim(current($ipAddresses)); // Take the first IP in the list
        } elseif ($request->server('HTTP_CLIENT_IP')) {
            $ipAddress = $request->server('HTTP_CLIENT_IP');
        } elseif ($request->server('HTTP_X_FORWARDED')) {
            $ipAddress = $request->server('HTTP_X_FORWARDED');
        } elseif ($request->server('HTTP_FORWARDED_FOR')) {
            $ipAddress = $request->server('HTTP_FORWARDED_FOR');
        } elseif ($request->server('HTTP_FORWARDED')) {
            $ipAddress = $request->server('HTTP_FORWARDED');
        } elseif ($request->server('REMOTE_ADDR')) {
            $ipAddress = $request->server('REMOTE_ADDR');
        }
        $ip = $request->header('X-Real-IP') ?? $request->header('X-Client-IP') ?? $request->ip();

        return $ip;
    }
}
