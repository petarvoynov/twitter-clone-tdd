@extends('layouts.app')

@section('content')
    {{ $tweet->body }}
    <br>
    @foreach($tweet->comments as $comment)
     {{ $comment->body }}
    @endforeach
@endsection