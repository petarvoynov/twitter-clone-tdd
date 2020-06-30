@extends('layouts.master')

@section('content')
<div class="row d-flex justify-content-start align-items-center py-2">
    <div class="col-1">
        <a href="{{ url()->previous() }}">
            <ion-icon style="font-size:20px" name="arrow-back-outline"></ion-icon>
        </a>
    </div>
    <div class="col-11">
        <h2>Tweet</h2>
        <p>30k Tweets</p>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card img-fluid mx-auto" style="width: 36rem;">
            <img class="card-img-top" src="https://www.talkwalker.com/images/2020/blog-headers/image-analysis.png" alt="Card image cap">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    @if(auth()->id() != $user->id)
                        @if(!auth()->user()->followings()->where('leader_id', $user->id)->exists())
                            <form action="{{ route('users.follow', ['user' => $user->id]) }}"  method="POST">
                                @csrf
                                <button class="btn btn-primary btn-sm" type="submit">Follow</button>
                            </form>
                        @else
                            <form action="{{ route('users.unfollow', ['user' => $user->id]) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary" type="submit">Unfollow</button>
                            </form>
                        @endif
                    @endif
                </div>
                
                <h6 class="card-subtitle mt-1 mb-2 text-muted">{{ $user->email }}</h6>
                <p class="card-text">Fake Description</p>
                <div class="d-flex row">
                    <p class="card-text col-lg-4">Fake Joined April 2009</p>
                    <p class="card-text col-lg-4">Fake Location</p>
                    <p class="card-text col-lg-4">Fake Description</p>
                </div>
                <div class="row d-flex">
                    <p class="col-md-6"><span class="font-weight-bold mr-1">166</span>Following</p>
                    <p class="col-md-6"><span class="font-weight-bold mr-1">90.6k</span>Followers</p>
                </div>
                <p>Fake Followed by Adam Wathan, Laravel, and 2 others you follow</p>
            </div>
        </div>
    </div>
</div>

@forelse ($user->tweets as $tweet)
    @include('tweets.components.tweets_card')    
@empty
    <p class="lead text-center mt-5">There are no tweets</p>
@endforelse

@endsection

@section('javascript')
    <script src="{{ asset('js/toggle_tweet_comment_textarea.js') }}" defer></script>
@endsection