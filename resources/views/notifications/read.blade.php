@extends('layouts.master')

@section('content')
    <h2 class="text-center">Read Notifications</h2>
    @include('notifications.components.navigation')
    
    @foreach($readNotifications as $notification)
        <div class="row">
            <div id="{{ $notification->data['tweet_id'] }}" class="col-12 notification alert alert-light" role="alert">
                <div>
                    {{ $notification->data['tweet_owner_name'] }}<small> tweeted:</small>
                </div>
                <div>{{ Str::limit($notification->data['tweet_body'], 230) }}</div>
            </div>
        </div>
    @endforeach  
@endsection

@section('scripts')
    <script src="{{ asset('js/openNotification.js') }}"></script>
@endsection