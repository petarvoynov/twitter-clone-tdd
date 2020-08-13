<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;

class PinnedListsController extends Controller
{
    public function store(TwitterList $list)
    {
        $list->pin();

        return back();
    }
}
