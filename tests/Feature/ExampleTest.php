<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('shows login page', function () {
    $response = $this->get('/login');

    $response->assertSuccessful();
});
