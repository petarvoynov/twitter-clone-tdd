@extends('layouts.master')

@section('content')
    <h1>Edit your profile {{ $user->name }}</h1>

    <form class="mt-4" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" cols="30" rows="10">{{ $user->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $user->location }}">
        </div>

        <div>
            <label for="message_settings">Chat privacy</label>
            <select class="form-control form-control-sm" name="message_settings" aria-describedby="chat_settings">
                <option value="everyone" {{ ($user->message_settings == 'everyone') ? 'selected' : '' }}>Everyone</option>
                <option value="friends" {{ ($user->message_settings == 'friends') ? 'selected' : '' }}>Friends</option>
            </select>
            <small id="chat_settings" class="form-text text-muted">Chose who can send you messages.</small>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
@endsection