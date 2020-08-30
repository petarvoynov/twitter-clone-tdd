@extends('layouts.master')

@section('content')
    <div class="row d-flex justify-content-start align-items-center py-2">
        <div class="col-1">
            <a href="{{ url()->previous() }}">
                <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div class="col-11">
            <h2 class="font-weight-bold text-center border-bottom">Your chat with {{ $user->name }}</h2>
        </div>
    </div>

    <div class="d-flex justify-content-center mb-3">
        <form action="">
            <button class="btn btn-primary">Load more</button>
        </form>
        <form action="">
            <button class="btn btn-primary ml-2">Load all</button>
        </form> 
    </div>

    <div class="border">
        @foreach($messages as $message)
            @if($message->to == auth()->id())
                <div class="row">
                    <div class="col-12 d-flex">
                        <div class="chat-box">
                            <img style="width: 30px; height: 30px;" src="{{ $message->sender->profilePicture() }}" alt="">
                            {{ $message->message }}
                        </div>
                        
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <div class="chat-box-auth">{{ $message->message }}</div>
                    </div>
                </div>
            @endif
        @endforeach

        <form class="m-2" action="{{ route('messages.store', ['user' => $user->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="message" id="" cols="10" rows="3" placeholder="Send message..."></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
@endsection