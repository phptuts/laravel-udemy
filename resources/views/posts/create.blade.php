@extends('layouts.app')

@section('title', 'Create the post')

@section('content')

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        @include('posts.partials.form')
        <div><input class="btn btn-primary btn-block mt-2" type="submit" value="create"></div>
    </form>

@endsection
