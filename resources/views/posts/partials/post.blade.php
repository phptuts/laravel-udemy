    <h3> <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h3>


    <div class="mb-3">
        <a class="btn-primary btn" href="{{ route('posts.edit', ['post' => $post->id]) }}">edit</a>
        <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" class="btn btn-primary" value="Delete">
        </form>
    </div>
