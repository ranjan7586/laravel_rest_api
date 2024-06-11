<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $req){
        $file=$req->file('image');
        $filename=time().'_'.$file->getClientOriginalName();
        $path=$req->file('image')->storeAs('images',$filename,'public');
        $result=Image::create(['image_name'=>$path]);
        return response()->json([
            'message'=>'success',
            'path'=>$path,
            'result'=>$result
        ],200);
    }
}
