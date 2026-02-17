@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">All Notes</h1>

@if($notes->isEmpty())
    <p>No notes found.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($notes as $note)
            <div class="bg-white p-4 rounded shadow">
                <h2 class="font-bold text-lg">{{ $note->title }}</h2>
                <p class="mt-2">{{ $note->content }}</p>
                <div class="mt-4 flex justify-between">
                    <a href="{{ route('notes.edit', $note) }}" class="text-blue-600">Edit</a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this note?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
