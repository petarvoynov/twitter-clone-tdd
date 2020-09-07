@extends('layouts.master')

@section('content')
    <div class="row d-flex justify-content-start align-items-center py-2">
        <div class="col-1">
            <a href="{{ url()->previous() }}">
                <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div class="col-8">
            <h2 class="text-center">All Notifications</h2>
        </div>
        <div class="col-3">
            <div>
                <form action="{{ route('notifications.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-primary btn-sm">Mark All As Read</button>
                </form>
            </div>
            
            <div class="mt-2">
                <form action="{{ route('notifications.destroyAllRead') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-primary" type="submit">Clear Read Notifications</button>
                </form>
            </div>
        </div>
    </div>
    
    @include('notifications.components.navigation')

    @foreach($notifications as $notification)
        <div  class="row">
            <a style="width:100%" href="{{ route('tweets.show', ['tweet' => $notification->data['tweet_id']]) }}">
                <div id="{{ $notification->data['tweet_id'] }}" class="col-12 notification alert {{ is_null($notification->read_at) ? 'alert-primary' : 'alert-light' }}" role="alert">
                    <div>
                        {{ $notification->data['tweet_owner_name'] }}<small> tweeted:</small>
                    </div>
                    <div>{{ Str::limit($notification->data['tweet_body'], 230) }}</div>
                </div>
            </a>
        </div>
    @endforeach  
    {{ $notifications->links() }} 
@endsection