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
            <img class="card-img-top" src="{{ $user->profilePicture()}}" alt="profile picture">
            @if(auth()->id() == $user->id)
                <a class="position-absolute btn btn-secondary mt-2 ml-2" href="{{ route('user-profile-picture.edit', ['user' => $user->id]) }}">Edit Image</a>
            @endif
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
                                <button class="btn btn-primary btn-sm" type="submit">Unfollow</button>
                            </form>
                        @endif
                    @else
                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit', ['user' => $user->id]) }}">Edit</a>
                    @endif
                </div>
                
                <p class="card-text">{{ $user->description }}</p>
                <div class="d-flex row">
                    <p class="card-text col-lg-6">Joined {{ $user->created_at->toFormattedDateString() }}</p>
                    <p class="card-text col-lg-6">{{ $user->location }}</p>
                </div>
                <div class="row d-flex">
                    <p class="col-md-6"><span class="font-weight-bold mr-1">{{ $user->followings_count }}</span>Following</p>
                    <p class="col-md-6"><span class="font-weight-bold mr-1">{{ $user->followers_count }}</span>Followers</p>
                </div>
                <p>Followed by {{ $followedBy }} and {{ $user->followers_count - 3 }} others.</p>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->followings()->where('leader_id', $user->id)->exists() || auth()->id() === $user->id)
    @if(count($activities) > 0)
        @foreach ($activities as $activity)
            @if($activity->subject_type == 'App\\Tweet')    
                @include('tweets.components.tweet_card')
            @elseif($activity->subject_type == 'App\\Comment')
                @include('tweets.components.comment_card')
            @endif
        @endforeach
        {{ $activities->links() }}
    @else
        <p class="lead text-center mt-5">There are no activities for this user.</p>    
    @endif
@endif


@endsection

@section('javascript')
    <script src="{{ asset('js/toggle_tweet_comment_textarea.js') }}" defer></script>
@endsection