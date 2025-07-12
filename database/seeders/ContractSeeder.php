<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Contract;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $brands = Brand::all();
        $workers = Worker::all();

        foreach ($workers as $worker) {
            $brand = $brands->random();

            Contract::create([
                'worker_id' => $worker->id,
                'brand_id' => $brand->id,
                'start_date' => now()->subMonths(rand(1, 24)),
                'end_date' => null,
                'salary' => rand(5000, 25000),
                'is_active' => true,
            ]);
        }
    }
}
