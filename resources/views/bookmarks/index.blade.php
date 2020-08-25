@extends('layouts.master')

@section('content')
    <h1 class="border-bottom text-center">Bookmarks</h1>

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