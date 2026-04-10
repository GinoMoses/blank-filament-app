<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests can view the login page', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSee('Bank Pytań Egzaminacyjnych');
});

test('authenticated users are redirected away from the login page', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/login')
        ->assertRedirect('/exams');
});
