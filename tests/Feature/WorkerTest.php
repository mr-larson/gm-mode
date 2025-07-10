<?php

use App\Models\Worker;
use App\Models\Brand;
use App\Models\User;
use App\Enums\WorkerGender;
use App\Enums\WorkerStatus;
use App\Enums\WorkerStyle;
use App\Enums\WorkerCategory;
use App\Enums\WorkerAlignment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a worker with enums', function () {
    $user = User::factory()->create();
    $brand = Brand::factory()->create(['user_id' => $user->id]);

    $worker = Worker::create([
        'firstname' => 'Jane',
        'lastname' => 'Doe',
        'gender' => WorkerGender::woman,
        'status' => WorkerStatus::active,
        'style' => WorkerStyle::highFlyer,
        'category' => WorkerCategory::heavyweight,
        'alignment' => WorkerAlignment::tweener,
        'brand_id' => $brand->id,
        'user_id' => $user->id,
    ]);

    expect($worker)->toBeInstanceOf(Worker::class)
        ->and($worker->full_name)->toBe('Jane Doe')
        ->and($worker->alignment)->toBe(WorkerAlignment::tweener);
});
