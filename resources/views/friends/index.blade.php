@extends('layouts.app')

@section('content')
    <div class="container">
        @forelse($friends as $friend)
        <p>{{ $friend->name }}</p>
        @empty
            No tienes amigos
        @endforelse
    </div>
@endsection
