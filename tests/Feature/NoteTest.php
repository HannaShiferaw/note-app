<?php

use App\Models\Note;
use App\Models\User;

test('guests are sent to the login page', function () {
    $this->get(route('notes.index'))->assertRedirect(route('login'));
});

test('a user sees only their own notes', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    Note::factory()->for($user)->create(['title' => 'My note']);
    Note::factory()->for($other)->create(['title' => 'Someone else\'s note']);

    $this->actingAs($user)
        ->get(route('notes.index'))
        ->assertOk()
        ->assertSee('My note')
        ->assertDontSee('Someone else\'s note');
});

test('a user can create a note', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('notes.store'), ['title' => 'Shopping', 'content' => 'Buy milk'])
        ->assertRedirect(route('notes.index'));

    $this->assertDatabaseHas('notes', [
        'title' => 'Shopping',
        'content' => 'Buy milk',
        'user_id' => $user->id,
    ]);
});

test('creating a note without a title is rejected', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('notes.store'), ['title' => '', 'content' => 'No title'])
        ->assertSessionHasErrors('title');

    $this->assertDatabaseCount('notes', 0);
});

test('a user can view, update and delete their own note', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    $this->actingAs($user)->get(route('notes.show', $note))->assertOk()->assertSee($note->title);

    $this->actingAs($user)
        ->put(route('notes.update', $note), ['title' => 'Updated', 'content' => 'New content'])
        ->assertRedirect(route('notes.index'));
    $this->assertDatabaseHas('notes', ['id' => $note->id, 'title' => 'Updated']);

    $this->actingAs($user)
        ->delete(route('notes.destroy', $note))
        ->assertRedirect(route('notes.index'));
    $this->assertDatabaseMissing('notes', ['id' => $note->id]);
});

test('a user cannot view, update or delete someone else\'s note', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $note = Note::factory()->for($other)->create();

    $this->actingAs($user)->get(route('notes.show', $note))->assertNotFound();
    $this->actingAs($user)
        ->put(route('notes.update', $note), ['title' => 'Stolen', 'content' => 'Stolen'])
        ->assertNotFound();
    $this->actingAs($user)->delete(route('notes.destroy', $note))->assertNotFound();
    $this->assertDatabaseHas('notes', ['id' => $note->id, 'title' => $note->title]);
});
