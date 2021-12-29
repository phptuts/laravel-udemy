@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    {{-- @each('posts.partials.post', $posts, 'post') --}}
    @forelse ($posts as $key => $post)
        {{-- @break($key == 2) --}}
        {{-- @continue($key == 1) --}}
        @include('posts.partials.post')
    @empty
        <div>No Posts</div>
    @endforelse
@endsection
