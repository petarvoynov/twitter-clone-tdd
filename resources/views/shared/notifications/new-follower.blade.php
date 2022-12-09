<div class="row">
    <a style="width:100%" href="{{ route('users.show', ['user' => $notification->data['user_id']]) }}">
        <div class="col-12 notification alert alert-primary" role="alert">
            <div>{{ $notification->data['user_name'] }} Followed you!</div>
        </div>
    </a> 
</div>