<?php

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a brand', function () {
    $user = User::factory()->create();

    $brand = Brand::create([
        'name' => 'Raw',
        'owner' => 'Triple H',
        'user_id' => $user->id,
    ]);

    expect($brand)->toBeInstanceOf(Brand::class)
        ->and($brand->name)->toBe('Raw')
        ->and($brand->user->id)->toBe($user->id);
});
