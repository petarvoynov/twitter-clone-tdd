@extends('layouts.master')

@section('content')
    @foreach ($lists as $list)
        {{ $list->name }}
    @endforeach
@endsection