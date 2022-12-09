@extends('layouts.master')

@section('content')
    <div class="row d-flex justify-content-start align-items-center py-2">
        <div class="col-1">
            <a href="{{ url()->previous() }}">
                <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div class="col-11">
            <h2 class="text-center">Unread Notifications</h2>
        </div>
    </div>

    @include('notifications.components.navigation')
    
    @foreach($unreadNotifications as $notification)
        @if($notification->type == 'tweet-created')
            @include('shared.notifications.tweet-created', ['notification' => $notification])
        @elseif($notification->type == 'new-follower')
            @include('shared.notifications.new-follower', ['notification' => $notification])
        @elseif($notification->type == 'unfollowed')
            @include('shared.notifications.unfollowed', ['notification' => $notification])
        @endif
    @endforeach  
    {{ $unreadNotifications->links() }} 
@endsection