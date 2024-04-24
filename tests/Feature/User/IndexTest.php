<?php

use App\Models\User;

test('user dashboard can be rendered', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('user.dashboard'));

    $response->assertOk();
});
