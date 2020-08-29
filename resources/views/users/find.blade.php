@extends('layouts.master')

@section('content')
    @forelse($users as $user)
        {{ $user->name }}
    @empty    
        <p class="lead text-center">There are no users with name: {{ $searchName }}</p>
    @endforelse
@endsection