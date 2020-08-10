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

        if(request()->hasFile('cover_image')){
            $path = request()->file('cover_image')->store('cover_images', 'public');
            $data['cover_image'] = $path;
        }
        
        auth()->user()->lists()->create($data);

        /* Need to make a redirect to the twitter-lists.show  when you create it*/
        return back();
    }

    public function show(TwitterList $list)
    {
        return view('twitter-lists.show', compact('list'));
    }
}
