@extends('layouts.master')

@section('content')
    <div class="row d-flex justify-content-start align-items-center py-2">
        <div class="col-1">
            <a href="{{ url()->previous() }}">
                <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div class="col-11">
            <h1 class="border-bottom text-center">Bookmarks</h1>
        </div>
    </div>
    

    <form action="{{ route('bookmarks.search') }}" method="POST">
        @csrf
        <input class="searchbar" type="text" name="body" placeholder="Search bookmarked tweets">
        <button class="btn btn-primary btn-sm rounded-pill">Search</button>
    </form>

    @foreach ($bookmarks as $bookmark)
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h5><a href="{{ route('users.show', ['user' => $bookmark->tweet->user_id]) }}"><img class="rounded-circle mr-2" src="{{ $bookmark->tweet->user->profilePicture() }}" alt="profile picture" width="40px" height="40px">{{ $bookmark->tweet->user->name }}</a></h5> 
                <div>
                    <small>{{ $bookmark->tweet->created_at->diffForHumans() }}</small>
                    <form action="{{ route('bookmarks.destroy', ['tweet' => $bookmark->tweet->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-primary">Unbookmark</button>
                    </form>
                </div>
                
            </div>
            <div class="card-body">
                <div class="tweet-body">
                    <a href="{{ route('tweets.show', ['tweet' => $bookmark->tweet->id]) }}">
                    {{ $bookmark->tweet->body }}
                    </a>
                </div>
            </div>  
        </div>       
    @endforeach
    {{ $bookmarks->links() }}
       
@endsection