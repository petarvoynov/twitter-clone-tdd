<div class="row">
    <div class="col-lg-3 d-flex flex-column justify-content-between">
        <small>3255 Comments</small>
        <button id="{{ $tweet->id }}" class="btn btn-primary btn-sm comment-button">Comment</button>
    </div>
    <div class="col-lg-3 d-flex flex-column justify-content-between">
        <small>2755 Retweets</small>
        <button class="btn btn-primary btn-sm">Retweet</button>
    </div>
    <div class="col-lg-3 d-flex flex-column justify-content-between">
        <small>12705 Likes</small>
        <div>
            @if(!$tweet->isLiked())
                <form action="{{ route('tweets-like.store', ['tweet' => $tweet->id]) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-sm">Like</button>
                </form>
            @else
                <form action="{{ route('tweets-unlike.destroy', ['tweet' => $tweet->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-secondary btn-sm">Unlike</button>
                </form>
            @endif
        </div>
    </div>
    <div class="col-lg-3 d-flex flex-column justify-content-between">
        <small>5555 Bookmarks</small>
        <button class="btn btn-primary btn-sm">Bookmark</button>
    </div>
</div>



{{-- <div class="d-flex justify-content-between">
    <p>3255 Comments</p>
    <p>2755 Retweets</p>
    <p>12705 Likes</p>
    <p>5555 Bookmarks</p>
</div>

<div class="row d-flex justify-content-between">
    <div class="col-md-3">
        <button id="{{ $tweet->id }}" class="btn btn-primary btn-sm comment-button">Comment</button>
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary btn-sm">Retweet</button>
    </div>
    <div class="col-md-3">
        <div>
            @if(!$tweet->isLiked())
                <form action="{{ route('tweets-like.store', ['tweet' => $tweet->id]) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-sm">Like</button>
                </form>
            @else
                <form action="{{ route('tweets-unlike.destroy', ['tweet' => $tweet->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-secondary btn-sm">Unlike</button>
                </form>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary btn-sm">Bookmark</button>
    </div>
    
    
    
    
</div> --}}