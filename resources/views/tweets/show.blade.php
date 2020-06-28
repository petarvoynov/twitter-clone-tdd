@extends('layouts.master')

@section('content')
<div class="d-flex justify-content-start align-items-center py-2">
    <div class="col-1">
        <a href="{{ route('tweets.index') }}">
            <ion-icon style="font-size:20px" name="arrow-back-outline"></ion-icon>
        </a>
    </div>
    <div class="col-11">
        <h2 class="ml-4">Tweet</h2>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header d-flex justify-content-between">
        <h5>{{ $tweet->user->name }}</h5> <small>{{ $tweet->created_at->diffForHumans() }}</small>
    </div>
    <div class="card-body">
        <p>{{ $tweet->body }}</p>
    
        <div class="mt-2 text-muted border-bottom">
            <small>{{ $tweet->created_at->isoFormat('HH:mm A MMM D, Y') }}</small>
        </div>

        <div class="mt-2 border-bottom d-flex">
            <p>
                <span class="font-weight-bold">10</span>
                <span class="text-muted"> Retweets</span>
            </p>
            <p class="ml-3">
                <span class="font-weight-bold">20</span>
                <span class="text-muted">Likes</span>
                </p>
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

@foreach($tweet->comments as $comment)
    <li class="list-group-item mt-2">
        <div class="row">
            <div class="col-lg-11 d-flex flex-column">
                <div>{{ $comment->user->name }} commented:</div>
                <div>{{ $comment->body }}</div>
                <div>
                    <small class="text-secondary">{{ $comment->created_at->diffForHumans() }}</small>
                    <small class="text-secondary">{{ $comment->likes_count }} {{ Str::plural('Like', $comment->likes_count) }}</small>
                </div>
            </div>
            <div class="col-lg-1 d-flex justify-content-center align-items-center"> 
                @if(!$comment->isLiked())
                    <div>
                        <form id="like-form"  action="{{ route('likes.store', ['comment' => $comment->id]) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary btn-sm">Like</button>
                        </form>
                    </div>
                @else
                    <div>
                        <form id="like-form"  action="{{ route('likes.destroy', ['comment' => $comment->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary btn-sm">Unlike</button>
                        </form>
                    </div>  
                @endif
            </div>
        </div>   
    </li>
@endforeach  
   
@endsection

@section('javascript')
    <script src="{{ asset('js/toggle_tweet_comment_textarea.js') }}" defer></script>
    <script>
        window.onload = function(){
            let form = document.querySelector('#like-form');
            let heartButton = document.querySelectorAll('#heart-outline');

            for
            heartButton.addEventListener('click', function(){
                form.submit();
            }); 
        };
    </script>
@endsection