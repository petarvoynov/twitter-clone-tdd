@extends('layouts.master')

@section('content')
    <div id="buttons" class="d-flex justify-content-between my-2">
        <div class="d-flex align-items-center">
            <a class="mr-2" href="{{ url()->previous() }}">
                <svg style="width: 26px; color:black;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
            @if(!$list->isPinned())
                <form action="{{ route('pinned-lists.store', ['list' => $list->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">Pin List</button>
                </form>
            @else
                <form action="{{ route('pinned-lists.destroy', ['list' => $list->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-primary">Unpin List</button>
                </form>
            @endif
        </div>
        <div>
            <a href="#" class="btn btn-sm btn-primary">All Members</a>
            <a href="{{ route('twitter-list-users.create', ['list' => $list->id]) }}" class="btn btn-sm btn-primary ml-2">Add Members</a>
            <a href="#" class="btn btn-sm btn-primary ml-2">Edit List</a>
        </div>
    </div>
    <div class="border-bottom">
        <div class="list-cover-image">
            <img src="{{ $list->coverImage() }}" alt="list cover image">
        </div>
        <div class="text-center mt-2">
            <h3 class="font-weight-bold">{{ $list->name }}</h3>
            <div class="d-flex text-center justify-content-center">
                <p class="font-weight-bold">{{ $listUsers->count() }}<span class="text-muted ml-1">{{ Str::plural('Member', $listUsers->count()) }}</span></p>
                <p class="font-weight-bold ml-4">58<span class="text-muted ml-1">Subscribers</span></p>
            </div>
        </div>
    </div>
    
    @if(count($activities) > 0)
        @foreach ($activities as $activity)
            @if($activity->subject_type == 'App\\Tweet')    
                @include('tweets.components.tweet_card')
            @elseif($activity->subject_type == 'App\\Comment')
                @include('tweets.components.comment_card')
            @endif
        @endforeach
        {{ $activities->links() }}
    @endif
@endsection

@section('javascript')
    <script src="{{ asset('js/toggle_tweet_comment_textarea.js') }}" defer></script>
@endsection