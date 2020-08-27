@extends('layouts.master')

@section('content')
  <div class="row d-flex justify-content-start align-items-center py-2 border-bottom">
    <div class="col-1">
        <a href="{{ url()->previous() }}">
            <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
        </a>
    </div>
    <div class="col-11">
      <h1>Edit your profile picture {{ $user->name }}</h1>
    </div>
  </div>

<form class="mt-4" action="{{ route('user-profile-picture.store', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="profile_picture">Profile Picture</label>
      <input type="file" class="form-control" id="profile_picture" name="profile_picture" aria-describedby="profilePictureHelp" accept="image/*">
      <small id="profilePictureHelp" class="form-text text-muted">Chose your profile picture</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection