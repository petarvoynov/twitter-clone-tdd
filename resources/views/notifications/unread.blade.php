@extends('layouts.master')

@section('content')
<h2 class="text-center">Unread Notifications</h2>
<div class="row d-flex justify-content-between text-center">
    <div class="col-xl-4 buttons {{ (url()->current() == url('/notifications')) ? 'active' : '' }}">
        <a href="{{ route('notifications.index') }}">All notifications</a>
    </div>
    <div class="col-xl-4 buttons">
        <a href="{{ route('notifications.unread') }}">Unread notifications</a>
    </div>
    <div class="col-xl-4 buttons">
        <a href="">Read notifications</a>
    </div>
</div>
@foreach($unreadNotifications as $notification)
    <div  class="row">
        <div id="{{ $notification->data['tweet_id'] }}" class="col-12 notification alert alert-primary" role="alert">
            <div>
                {{ $notification->data['tweet_owner_name'] }}<small> tweeted:</small>
            </div>
            <div>{{ Str::limit($notification->data['tweet_body'], 230) }}</div>
        </div>
    </div>
@endforeach

<script>
window.onload = function(){
    let notifications = document.querySelectorAll('.notification');

    for(let i = 0; i < notifications.length; i++){
        notifications[i].addEventListener('click', function(e){
            if(e.target.id){
                location.href = "/tweets/" + e.target.id;
            } else {
                location.href = "/tweets/" + e.target.parentNode.id;
            }
        });
    }
};
</script>    
@endsection

