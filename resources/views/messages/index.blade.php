@extends('layouts.master')

@section('content')
    <div class="row d-flex justify-content-start align-items-center py-2">
        <div class="col-1">
            <a href="{{ url()->previous() }}">
                <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div class="col-11">
            <h1 class="border-bottom text-center">All Conversations</h1>
        </div>
    </div>

    @forelse($users as $user)
    <a href="{{ route('messages.show', ['user' => $user->id]) }}">
        <div class="chat-pannel row d-flex align-items-center mt-2">
            <div class="chat-image col-2">
                <img src="{{ $user->profilePicture() }}" alt="user profile picture">
            </div>
            <div class="chat-last-message col-10">
                <div class="lead">{{ $user->name }}</div>
                <div class="d-flex justify-content-between">
                    <div>
                        {{ auth()->user()->lastMessage($user)->message }} 
                    </div>
                    <small>{{ auth()->user()->lastMessage($user)->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </a>
    @empty
        <p class="lead">You have started a conversation yet.</p>
    @endforelse

    
@endsection