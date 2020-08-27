@extends('layouts.master')

@section('content')
    <div class="row d-flex justify-content-start align-items-center py-2">
        <div class="col-1">
            <a href="{{ url()->previous() }}">
                <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div class="col-11">
            <h2 class="text-center">All Notifications</h2>
        </div>
    </div>
    
    @include('notifications.components.navigation')

    @foreach($notifications as $notification)
        <div  class="row">
            <div id="{{ $notification->data['tweet_id'] }}" class="col-12 notification alert {{ is_null($notification->read_at) ? 'alert-primary' : 'alert-light' }}" role="alert">
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