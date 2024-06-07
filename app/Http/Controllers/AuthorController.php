<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show(){
        $result=Author::with('post')->find('1');
        // $result=Author::doesntHave('post')->get();
        // $result=Author::has('post')->with('post')->get();
        return $result;
    }
}
