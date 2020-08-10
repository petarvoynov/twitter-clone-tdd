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

    public function store()
    {
        request()->validate([
            'name' => 'required'
        ]);

        auth()->user()->lists()->create([
            'name' => request('name'),
            'description' => request('description'),
            'is_private' => request('is_private')
        ]);
    }
}
