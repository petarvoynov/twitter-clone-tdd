<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;
use App\ListUser;

class TwitterListUsersController extends Controller
{
    public function store(TwitterList $list)
    {
        if(auth()->id() != $list->user_id){
            abort(403);
        }

        ListUser::create([
            'user_id' => request('user_id'),
            'list_id' => $list->id
        ]);
    }
}
