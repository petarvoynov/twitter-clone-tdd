@extends('layouts.master')

@section('content')
    <h1 class="font-weight-bold text-center border-bottom">Create List</h1>

    <form action="{{ route('twitter-lists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
        </div>

        <div class="custom-file">
            <input type="file" class="custom-file-input" id="cover_image" name="cover_image">
            <label class="custom-file-label" for="cover_image">Choose file</label>
        </div>
        
        <div class="form-check mt-3">
            <input type="checkbox" class="form-check-input" id="is_private" name="is_private" value="1">
            <label class="form-check-label" for="is_private">Make it private</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

@endsection