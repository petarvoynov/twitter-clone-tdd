<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;

class PinnedListsController extends Controller
{
    public function store(TwitterList $list)
    {
        $this->authorize('update', $list);

        $list->pin();

        return back();
    }
}
