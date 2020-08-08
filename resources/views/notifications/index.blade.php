@extends('layouts.master')

@section('content')
    @foreach($notifications as $notification)
        <p>{{ $notification->data['tweet_owner_name'] }} tweeted:</p>
        <p>{{ $notification->data['tweet_body'] }}</p>
    @endforeach
@endsection