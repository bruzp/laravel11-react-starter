<?php

use App\Models\User;

test('user dashboard answers can be displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('user.answers.index'));

    $response->assertOk();
});
