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
                <span class="font-weight-bold">{{ $tweet->likes_count }}</span>
                <span class="text-muted">{{ Str::plural('Like', $tweet->likes_count) }}</span>
            </p>
        </div>

        @include('tweets.components.tweet_buttons', ['activity' => $tweet])
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
                <div class="font-weight-bold">{{ $comment->user->name }}<small class="text-muted ml-2">commented:</small></div>
                <div class="mt-2">{{ $comment->body }}</div>
                
                @if(auth()->id() == $comment->user_id)
                    <button id="{{ $comment->id }}" class="btn btn-secondary btn-sm button-to-show-edit-form">Edit</button>
                    <div id="edit-comment-{{ $comment->id }}" class="mt-2 edit-comment">
                        <form action="{{ route('comments.update', ['tweet' => $tweet->id, 'comment' => $comment->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="" cols="30" rows="10">{{ $comment->body }}</textarea>
                            </div>
                            <button class="btn btn-primary mb-2">Update</button>
                        </form>
                    </div>
                @endif
                <div>
                    <small class="text-secondary">{{ $comment->created_at->diffForHumans() }}</small>
                    <small>
                        <span class="font-weight-bold ml-3">{{ $comment->likes_count }}</span> 
                        <span class="text-secondary">{{ Str::plural('Like', $comment->likes_count) }}</span>
                    </small>
                </div>
            </div>
            <div class="col-lg-1 d-flex justify-content-center align-items-start"> 
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

<script>
        let editForm = document.querySelectorAll('.edit-comment');
        let button = document.querySelectorAll('.button-to-show-edit-form')

        for(let i = 0; i < editForm.length; i++) {
            editForm[i].style.display = 'none';
        }
        
        for(let i = 0; i < button.length; i++){
            button[i].addEventListener('click', function(e) {
                let id = e.target.id;
                let currentEditForm = document.querySelector('#edit-comment-' + id);
                console.log();

                if(currentEditForm.style.display === 'none'){
                    currentEditForm.style.display = 'block';
                    e.target.textContent = 'Close';
                } else {
                    currentEditForm.style.display = 'none';
                    e.target.textContent = 'Edit';
                }
            });
        }

</script>
   
@endsection

@section('javascript')
    <script src="{{ asset('js/toggle_tweet_comment_textarea.js') }}" defer></script>
@endsection