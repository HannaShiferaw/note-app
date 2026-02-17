@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Note</h1>

<form action="{{ route('notes.update', $note) }}" method="POST" class="bg-white p-4 rounded shadow space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block font-bold mb-1">Title</label>
        <input type="text" name="title" value="{{ $note->title }}" class="border p-2 w-full" required>
    </div>
    <div>
        <label class="block font-bold mb-1">Content</label>
        <textarea name="content" class="border p-2 w-full" required>{{ $note->content }}</textarea>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
