@extends('layouts.master')

@section('content')
    <div class="d-flex justify-content-between align-items-center border-bottom">
        <h1 class="text-center my-2 font-weight-bold">Lists</h1>
        <div>
            <a class="btn btn-primary rounded-pill" href="{{ route('twitter-lists.create') }}">Create List</a>
        </div>
    </div>
    
    <div class="border-bottom">
        <h2 class="border-bottom font-weight-bold p-2">Pinned Lists</h2>
        @forelse($pinnedLists as $list)
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('twitter-lists.show', ['list' => $list->id]) }}">
                    <div class="d-flex align-items-center py-2">
                        <svg style="width:24px" viewBox="0 0 20 20" fill="currentColor" class="bookmark-alt w-6 h-6"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l4-2 4 2V6z" clip-rule="evenodd"></path></svg>
                        <img class="ml-2" style="width: 40px; height:40px;" src="{{ $list->coverImage() }}" alt="list cover image">
                        <div class="ml-2">{{ $list->name }}</div>
                    </div>
                </a>
                <form action="{{ route('pinned-lists.destroy',  ['list' => $list->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-primary">Unpin</button>
                </form>
            </div>
        @empty
            <div class="py-2">
                <div class="text-center text-muted">Nothing to see here yet — pin up to five of your favorite Lists to access them quickly.</div>
            </div>
        @endforelse
    </div>

    <div class="border-bottom mt-2 py-2">
        <h2 class="font-weight-bold">Your Lists</h2>
    </div>

    {{-- Stacked lists --}}

    {{-- @forelse($lists as $list)
        <div class="d-flex align-items-center py-2">
            <img style="width: 50px; height:50px;" src="{{ $list->coverImage() }}" alt="list cover image">
            <div class="ml-2">{{ $list->name }}</div>
        </div>
    @empty  
        <div class="text-center mt-4">
            <div class="lead font-weight-bold">You haven’t created any Lists yet</div>
            <div class="text-muted">When you do, it’ll show up here.</div>
            <a href="{{ route('twitter-lists.create') }}" class="btn btn-primary rounded-pill font-weight-bold mt-3 text-white">Create a List</a>
        </div>
    @endforelse --}}


    {{-- UI to show the lists in bootstrap 4 cards --}}

    <div class="row">
    @forelse($lists as $list)
        <div class="col-xl-6 mt-3">
            <a class="list-card" href="{{ route('twitter-lists.show', ['list' => $list->id]) }}">
                <div class="card">
                    <img class="card-img-top list-image img-fluid" src="{{ $list->coverImage() }}" alt="list cover image">
                    <div class="card-body">
                    <h5 class="card-title">{{ $list->name }}</h5>
                    <p class="card-text">{{ Str::limit($list->description, 60) }}</p>
                    <p class="card-text"><small class="text-muted">Created: {{ $list->created_at->toFormattedDateString() }}</small></p>
                    </div>
                </div>
            </a>  
        </div>
        @if($loop->iteration % 2 == 0)
            </div>
            <div class="row">
        @endif
    @empty  
        <div class="text-center mt-4 col-12">
            <div class="lead font-weight-bold">You haven’t created any Lists yet</div>
            <div class="text-muted">When you do, it’ll show up here.</div>
            <a href="{{ route('twitter-lists.create') }}" class="btn btn-primary rounded-pill font-weight-bold mt-3 text-white">Create a List</a>
        </div>
    @endforelse
    </div>
@endsection