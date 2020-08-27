@extends('layouts.master')

@section('content')
    <div class="row d-flex justify-content-start align-items-center py-2">
        <div class="col-1">
            <a href="{{ url()->previous() }}">
                <svg style="width: 26px;" viewBox="0 0 20 20" fill="currentColor" class="arrow-left w-6 h-6"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div class="col-11">
            <h1 class="font-weight-bold text-center border-bottom">Create List</h1>
        </div>
    </div>

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