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
        $data = request()->validate([
            'name' => 'required',
            'description' => '',
            'is_private' => '',
            'cover_image' => 'image'
        ]);

        auth()->user()->lists()->create($data);
    }
}
