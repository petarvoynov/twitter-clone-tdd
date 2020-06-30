<div class="card mt-3">
    <div class="card-header d-flex justify-content-between">
        <h5>{{ $tweet->user->name }}</h5> <small>{{ $tweet->created_at->diffForHumans() }}</small>
    </div>
    <div class="card-body">
        <div class="tweet-body border-bottom">
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