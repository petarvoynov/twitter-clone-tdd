@php
    $like = $activity;
@endphp
@if(get_class($like->likeable) === 'App\Tweet')
    <div class="card mt-4">
        <div class="card-header">
            <small>{{ $like->user->name }} liked a tweet:</small>
            <div class="d-flex justify-content-between mt-3">
                <h5>{{ $like->likeable->user->name }}</h5> 
                <small>{{ $like->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <div class="card-body">
            <div class="tweet-body border-bottom">
                <a href="{{ route('tweets.show', ['tweet' => $like->likeable->id]) }}">
                    {{ $like->likeable->body }}
                </a>
            </div>
            
            @include('tweets.components.tweet_buttons', ['activity' => $like->likeable])
        </div>
        <div id="comment-area-{{ $like->likeable->id }}" class="comment-area">
            <form action="{{ route('comments.store', $like->likeable) }}" method="POST">
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
@elseif(get_class($like->likeable) === 'App\Comment')
    <div class="card mt-4">
        <div class="card-header">
            <small>{{ $like->user->name }} liked a comment:</small>
            <div class="d-flex justify-content-between mt-3">
                <h5>{{ $like->likeable->user->name }}</h5> 
                <small>{{ $like->created_at->diffForHumans() }}</small>
            </div>
        </div>
        <div class="card-body">
            <div class="tweet-body border-bottom">
                <a href="{{ route('tweets.show', ['tweet' => $like->likeable->id]) }}">
                {{ $like->likeable->tweet->body }}
                </a>
            </div>
            
            {{-- @include('tweets.components.tweet_buttons', ['activity' => $retweet->tweet]) --}}
        </div>
        {{-- <div id="comment-area-{{ $retweet->tweet_id }}" class="comment-area">
            <form action="{{ route('comments.store', $retweet->tweet_id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="body" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm form-control">Send</button>
                </div>
            </form>
        </div> --}}
    </div>
    <div class="alert alert-success d-flex justify-content-between" role="alert">
       <div>{{ $like->likeable->body }}</div> 
       <svg style="width: 25px" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
    </div>
@endif