<div class="row mt-3">
    <div class="col-lg-3 d-flex flex-column justify-content-between">
        <small>
            <span class="font-weight-bold mr-1">3255</span>Comments
        </small>
        <button id="{{ $tweet->id }}" class="btn btn-primary btn-sm comment-button">Comment</button>
    </div>
    <div class="col-lg-3 d-flex flex-column justify-content-between">
        <small>
            <span class="font-weight-bold mr-1">2755</span>Retweets
        </small>
        <button class="btn btn-primary btn-sm">Retweet</button>
    </div>
    <div class="col-lg-3 d-flex flex-column justify-content-between">
        <small>
            <span class="font-weight-bold mr-1">12705</span>Likes
        </small>
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
        <small>
            <span class="font-weight-bold mr-1">5555</span>Bookmarks
        </small>
        <button class="btn btn-primary btn-sm">Bookmark</button>
    </div>
</div>