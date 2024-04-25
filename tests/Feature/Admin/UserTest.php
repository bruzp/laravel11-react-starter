<?php

use App\Models\User;
use App\Models\Admin;

test('admin users can be displayed', function () {
    $admin = Admin::first() ?: Admin::factory()->create();

    $response = $this
        ->actingAs($admin, Admin::GUARD)
        ->get(route('admin.users.index'));

    $response->assertOk();
});

test('admin user registration screen can be rendered', function () {
    $admin = Admin::first() ?: Admin::factory()->create();

    $response = $this
        ->actingAs($admin, Admin::GUARD)
        ->get(route('admin.users.create'));

    $response->assertOk();
});

test('admin can add user', function () {
    $admin = Admin::first() ?: Admin::factory()->create();
    $email = fake()->email();

    $response = $this
        ->actingAs($admin, Admin::GUARD)
        ->post(route('admin.users.store'), [
            'name' => fake()->name(),
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

    $user = User::where('email', $email)->first();

    $this->assertTrue((bool) $user);

    $response->assertRedirect(route('admin.users.edit', $user));
});

test('admin user edit screen can be rendered', function () {
    $admin = Admin::first() ?: Admin::factory()->create();
    $user = User::factory()->create();

    $response = $this
        ->actingAs($admin, Admin::GUARD)
        ->get(route('admin.users.edit', $user));

    $response->assertOk();
});

test('admin can update user', function () {
    $admin = Admin::first() ?: Admin::factory()->create();
    $user = User::factory()->create();
    $name = fake()->name();
    $email = fake()->email();

    $response = $this
        ->actingAs($admin, Admin::GUARD)
        ->put(route('admin.users.update', $user), [
            'id' => $user->id,
            'name' => $name,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.users.edit', $user));

    $user->refresh();

    $this->assertSame($name, $user->name);
    $this->assertSame($email, $user->email);
});

test('admin can delete user', function () {
    $admin = Admin::first() ?: Admin::factory()->create();
    $user = User::factory()->create();

    $response = $this
        ->actingAs($admin, Admin::GUARD)
        ->delete(route('admin.users.destroy', $user));

    $response->assertRedirect(route('admin.users.index'));

    $this->assertTrue($user->fresh()->deleted_at !== null);
});
