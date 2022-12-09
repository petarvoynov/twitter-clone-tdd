<div class="row">
    <a style="width:100%" href="{{ route('tweets.show', ['tweet' => $notification->data['tweet_id']]) }}">
        <div id="{{ $notification->data['tweet_id'] }}" class="col-12 notification alert alert-primary" role="alert">
            <div>
                {{ $notification->data['tweet_owner_name'] }}<small> tweeted:</small>
            </div>
            <div>{{ Str::limit($notification->data['tweet_body'], 230) }}</div>
        </div>
    </a> 
</div>