<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;

class TwitterListsController extends Controller
{
    public function index()
    {
        $lists = auth()->user()->lists;

        return view('twitter-lists.index', compact('lists'));
    }
}
