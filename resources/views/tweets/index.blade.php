@extends('layouts.master')

@section('content') 
    <div class="card">
        <div class="card-header font-weight-bold lead">
          Home
        </div>
        <div class="card-body">
          <h5 class="card-title text-muted">What's happening?</h5>
          <div>
            <form action="{{ route('tweets.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="body" cols="15" rows="10"></textarea>
                </div>
                <button class="btn btn-primary float-right" type="submit">Tweet</button> 
              </form>
          </div>
        </div>
    </div>

    @forelse ($tweets as $tweet)
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ $tweet->user->name }}</h5> <small>{{ $tweet->created_at->diffForHumans() }}</small>
        </div>
        <div class="card-body">
            <div class="tweet-body">
                <a href="{{ route('tweets.show', ['tweet' => $tweet->id]) }}">
                   {{ $tweet->body }}
                </a>
            </div>
            
            @include('tweets.components.tweet_buttons')
        </div>
        <div id="comment-area-{{ $tweet->id }}" class="comment-area">
            <form action="{{ route('comments.store', $tweet->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="body" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm form-control">Send</button>
                </div>
            </form>
        </div>
    </div>
    @empty
        <p class="lead text-center mt-5">There are no tweets</p>
    @endforelse

@endsection

@section('javascript')
    <script src="{{ asset('js/toggle_tweet_comment_textarea.js') }}" defer></script>
@endsection


