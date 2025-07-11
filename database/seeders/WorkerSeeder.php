<?php

namespace Database\Seeders;

use App\Enums\WorkerCategory;
use App\Enums\WorkerGender;
use App\Enums\WorkerStatus;
use App\Enums\WorkerStyle;
use App\Models\Brand;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $brands = Brand::all();

        $workers = [
            'André the Giant',
            'Arn Anderson',
            'Barry Windham',
            'Bobby Eaton',
            'Bret Hart',
            'British Bulldog',
            'Bruno Sammartino',
            'Bruiser Brody',
            'Dory Funk Jr.',
            'Dusty Rhodes',
            'Dynamite Kid',
            'Fabulous Freebirds',
            'Greg Valentine',
            'Harley Race',
            'Hart Foundation',
            'Hulk Hogan',
            'Ivan Koloff',
            'Jake Roberts',
            'Jerry Lawler',
            'Larry Zbyszko',
            'Magnum T.A.',
            'Mega Powers',
            'Michael P.S. Hayes',
            'Mr. Perfect',
            'Nikita Koloff',
            'Paul Orndorff',
            'Randy Savage',
            'Ric Flair',
            'Rick Rude',
            'Ricky Morton',
            'Ricky Steamboat',
            'Robert Gibson',
            'Road Warriors',
            'Roddy Piper',
            'Sgt. Slaughter',
            'Stan Lane',
            'Sting',
            'Superstar Billy Graham',
            'Ted DiBiase',
            'Terry Funk',
            'Tony Atlas',
        ];

        foreach ($workers as $name) {
            $brand = $brands->random();

            Worker::create([
                'firstname' => explode(' ', $name)[0],
                'lastname' => implode(' ', array_slice(explode(' ', $name), 1)),
                'nickname' => null,
                'gender' => WorkerGender::male->value,
                'age' => rand(25, 55),
                'style' => WorkerStyle::brawler->value,
                'status' => WorkerStatus::active->value,
                'category' => WorkerCategory::heavyweight->value,
                'height' => rand(170, 220),
                'weight' => rand(90, 150),
                'image' => null,
                'overall' => rand(70, 95),
                'popularity' => rand(50, 100),
                'endurance' => rand(50, 100),
                'promo_skill' => rand(40, 95),
                'wins' => rand(50, 500),
                'draws' => rand(0, 10),
                'losses' => rand(20, 100),
                'note' => null,
                'brand_id' => $brand->id,
                'user_id' => $user->id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
