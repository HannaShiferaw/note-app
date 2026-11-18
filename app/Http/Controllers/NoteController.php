<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NoteController extends Controller
{
    /**
     * Show only the logged-in user's notes, newest first.
     */
    public function index(): View
    {
        $notes = auth()->user()->notes()->latest()->get();

        return view('notes.index', compact('notes'));
    }

    public function create(): View
    {
        return view('notes.create');
    }

    /**
     * Save a new note owned by the logged-in user.
     */
    public function store(NoteRequest $request): RedirectResponse
    {
        $request->user()->notes()->create($request->validated());

        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    /**
     * Show one of the logged-in user's notes.
     * A note owned by someone else gives a 404, not their note.
     */
    public function show(Note $note): View
    {
        $this->authorizeNote($note);

        return view('notes.show', compact('note'));
    }

    public function edit(Note $note): View
    {
        $this->authorizeNote($note);

        return view('notes.edit', compact('note'));
    }

    public function update(NoteRequest $request, Note $note): RedirectResponse
    {
        $this->authorizeNote($note);

        $note->update($request->validated());

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }

    public function destroy(Note $note): RedirectResponse
    {
        $this->authorizeNote($note);

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }

    /**
     * Stop with a 404 unless the note belongs to the logged-in user.
     * A 404 (rather than 403) does not reveal that the note exists.
     */
    protected function authorizeNote(Note $note): void
    {
        if ($note->user_id !== auth()->id()) {
            abort(404);
        }
    }
}
