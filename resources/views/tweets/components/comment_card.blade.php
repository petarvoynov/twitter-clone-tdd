@php
    $comment = $activity->subject;    
@endphp

@if($activity->description == 'commented a tweet')
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <small>{{ $comment->user->name }} commented:</small>
                <small>{{ $activity->created_at->diffForHumans() }}</small>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <h5><a href="{{ route('users.show', ['user' => $comment->tweet->user_id]) }}"><img class="rounded-circle mr-2" src="{{ $comment->tweet->user->profilePicture() }}" alt="profile picture" width="40px" height="40px">{{ $comment->tweet->user->name }}</a></h5> 
                <small>{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <div class="card-body">
            <div class="tweet-body border-bottom">
                <a href="{{ route('tweets.show', ['tweet' => $comment->tweet_id]) }}">
                {{ $comment->tweet->body }}
                </a>
            </div>
            
            @include('tweets.components.tweet_buttons', ['tweet' => $comment->tweet])

            
        </div>
        <div id="comment-area-{{ $comment->tweet_id }}" class="comment-area">
            <form action="{{ route('comments.store', $comment->tweet_id) }}" method="POST">
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
    <div class="alert alert-primary d-flex justify-content-between flex-wrap" role="alert">
        <div>{{ $comment->body }}</div>
        <svg style="width: 25px" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
    </div>

@elseif($activity->description == 'this comment is being liked')
    <div class="card mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <small>{{ $activity->user->name }} liked a comment:</small>
                <small>{{ $activity->created_at->diffForHumans() }}</small>
            </div>
            
            <div class="d-flex justify-content-between mt-3">
                <h5><a href="{{ route('users.show', ['user' => $comment->user_id]) }}"><img class="rounded-circle mr-2" src="{{ $comment->user->profilePicture() }}" alt="profile picture" width="40px" height="40px">{{ $comment->user->name }}</a></h5> 
                <small>{{ $comment->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <div class="card-body">
            <div class="tweet-body border-bottom">
                <a href="{{ route('tweets.show', ['tweet' => $comment->tweet->id]) }}">
                {{ $comment->tweet->body }}
                </a>
            </div>
            
            @include('tweets.components.tweet_buttons', ['tweet' => $comment->tweet])
        </div>
        <div id="comment-area-{{ $comment->tweet_id }}" class="comment-area">
            <form action="{{ route('comments.store', $comment->tweet_id) }}" method="POST">
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
    <div class="alert alert-success d-flex justify-content-between flex-wrap" role="alert">
        <div>{{ $comment->body }}</div> 
        <svg style="width: 25px" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
    </div>
@endif