<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;

class TwitterListsController extends Controller
{
    public function index()
    {
        $lists = auth()->user()->lists;

        $pinnedLists = auth()->user()->lists->where('is_pinned', 1);

        return view('twitter-lists.index', compact('lists', 'pinnedLists'));
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
        
        $list = auth()->user()->lists()->create($data);

        return redirect()->route('twitter-lists.show', ['list' => $list->id]);
    }

    public function show(TwitterList $list)
    {
        return view('twitter-lists.show', compact('list'));
    }

    public function create()
    {
        return view('twitter-lists.create');
    }
}
