@extends('layouts.master')

@section('content') 
    <div class="card">
        <div class="card-header font-weight-bold lead">
          Home
        </div>
        <div class="card-body">
          <h5 class="card-title text-muted">What's happening?</h5>
          <div>
            <form action="{{ route('tweets.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="body" cols="15" rows="10"></textarea>
                </div>
                <button class="btn btn-primary float-right" type="submit">Tweet</button> 
              </form>
          </div>
        </div>
    </div>

    @forelse ($tweets as $tweet)
        @include('tweets.components.tweets_card')
    @empty
        <p class="lead text-center mt-5">There are no tweets</p>
    @endforelse

@endsection

@section('javascript')
    <script src="{{ asset('js/toggle_tweet_comment_textarea.js') }}" defer></script>
@endsection


