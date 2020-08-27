@extends('layouts.master')

@section('content')
    <div id="buttons" class="d-flex justify-content-between my-2">
        <div>
            <form action="{{ route('pinned-lists.store', ['list' => $list->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary">Pin List</button>
            </form> 
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