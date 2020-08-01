@extends('layouts.master')

@section('content')

<h1>Edit your profile picture {{ $user->name }}</h1>

<form class="mt-4" action="{{ route('user-profile-picture.store', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="profile_picture">Profile Picture</label>
      <input type="file" class="form-control" id="profile_picture" name="profile_picture" aria-describedby="profilePictureHelp">
      <small id="profilePictureHelp" class="form-text text-muted">Chose your profile picture</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection