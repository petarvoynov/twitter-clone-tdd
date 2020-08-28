<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterList;

class PinnedListsController extends Controller
{
    public function store(TwitterList $list)
    {
        $this->authorize('update', $list);

        if(auth()->user()->pinned_lists_count > 4){
            return back()->with('error', 'You cannot have more than 5 pinned lists.');
        }

        $list->pin();

        return back()->with('success', 'You successfully pinned ' . $list->name . '.');
    }

    public function destroy(TwitterList $list)
    {
        $list->unpin();

        return back()->with('success', 'You successfully unpinned ' . $list->name . '.');
    }
}
