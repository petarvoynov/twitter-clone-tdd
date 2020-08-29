@extends('layouts.master')

@section('content')
    <div class="row">
        @forelse($users as $user)
            <div class="col-6">
                <div class="card mt-2" style="width: 13rem;">
                    <img class="card-img-top" src="{{ $user->profilePicture() }}" alt="Card image cap">
                    <div class="card-body text-center">
                        <p class="card-text text-center">{{ $user->name }}</p>
                        <a class="btn btn-primary btn-sm" href="{{ route('users.show', ['user' => $user->id]) }}">View Profile</a>
                    </div>
                </div>
            </div>

        @if($loop->iteration % 2 == 0)
            </div>
            <div class="row">
        @endif        
        
        @empty    
            <p class="lead text-center">There are no users with name: {{ $searchName }}</p>
        @endforelse
    </div>    
@endsection