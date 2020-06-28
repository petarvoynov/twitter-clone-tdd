<div class="d-flex justify-content-between mt-3">
    <button id="{{ $tweet->id }}" class="btn btn-primary btn-sm comment-button">Comment</button>
    <button class="btn btn-primary btn-sm">Retweet</button>
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
    <button class="btn btn-primary btn-sm">Bookmark</button>
</div>