<div class="row">
    <a style="width:100%" href="{{ route('users.show', ['user' => $notification->data['user_id'], 'notification_id' => $notification->id]) }}">
        <div class="col-12 notification alert {{ is_null($notification->read_at) ? 'alert-primary' : 'alert-light' }}" role="alert">
            <div>{{ $notification->data['user_name'] }} unfollowed you!</div>
        </div>
    </a> 
</div>