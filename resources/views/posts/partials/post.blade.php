@if ($loop->even)
    <div>{{ $key }}) {{ $post['title'] }}</div>

@else
    <div style="background-color: red;">{{ $key }}) {{ $post['title'] }}</div>
@endif
