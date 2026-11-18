<?php

it('redirects the home page to the notes list', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('notes.index'));
});
