<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class HomeController extends Controller
{

public function index()
{
    $comments = Comment::all();
    return view('layouts.app', ['comments' => $comments]);
}

}
