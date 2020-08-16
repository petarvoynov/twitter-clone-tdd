@extends('layouts.master')

@section('content')

    <form action="">
        <input type="text" placeholder="Search Users">
    </form>

    @if($followings->count() > 0)
        <div class="row d-flex justify-content-around">
        @foreach ($followings as $following)
            <div class="col-6">
                <div class="card mt-2" style="width: 13rem;">
                    <img class="card-img-top" src="{{ $following->profilePicture() }}" alt="Card image cap">
                    <div class="card-body">
                    <p class="card-text text-center">{{ $following->name }}</p>
                    <form action="{{ route('twitter-list-users.store', ['list' => $list->id, 'user_id' => $following->id]) }}" class="d-flex justify-content-center" method="POST">
                        @csrf
                        <button class="btn btn-primary btn-sm">Add to List</button>
                    </form>
                    </div>
                </div>
            </div>
            @if($loop->iteration % 2 == 0)
                </div>
                <div class="row">
            @endif
        @endforeach
        </div>
    @endif

    <hr>
    @foreach ($followings as $following)
        {{ $following->name }} <br>
    @endforeach
@endsection