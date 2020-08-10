<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;

class TwitterListsController extends Controller
{
    public function index()
    {
        $lists = TwitterList::where('user_id', auth()->id())->get();

        return view('twitter-lists.index', compact('lists'));
    }
}
