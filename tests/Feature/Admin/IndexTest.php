<?php

use App\Models\Admin;

test('admin index can be displayed', function () {
    $admin = Admin::first() ?: Admin::factory()->create();

    $response = $this
        ->actingAs($admin, Admin::GUARD)
        ->get(route('admin.dashboard.index'));

    $response->assertOk();
});
