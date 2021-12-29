@extends('layouts.app')

@section('title', $post['title'])

@section('content')
    @if ($post['is_new'])
        <div>This is a new blog post</div>
    @else
        <div>Blog post is old</div>
    @endif

    @unless($post['is_new'])
        <div>It's an old blog post.. using unless</div>
    @endunless

    @isset($post['has_comments'])
        <div>The post has some comments</div>
    @endisset

    <h1>{{ $post['title'] }}</h1>
    <p>{{ $post['content'] }}</p>
@endsection
