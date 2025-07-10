<?php

namespace Database\Factories;

use App\Enums\WorkerAlignment;
use App\Enums\WorkerCategory;
use App\Enums\WorkerGender;
use App\Enums\WorkerStatus;
use App\Enums\WorkerStyle;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'gender' => WorkerGender::man,
            'status' => WorkerStatus::Active,
            'style' => WorkerStyle::Brawler,
            'category' => WorkerCategory::heavyweight,
            'alignment' => WorkerAlignment::tweener,
            'brand_id' => Brand::factory(),
            'user_id' => User::factory(),
        ];
    }
}
