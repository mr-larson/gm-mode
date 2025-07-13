<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Enums\BrandStyle;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $brands = [
            [
                'name' => 'WWF',
                'owner' => 'Vince McMahon',
                'booker' => 'Vince McMahon',
                'based_in' => 'Stamford',
                'country' => 'USA',
                'money' => 1000000,
                'style' => BrandStyle::style1,
                'color' => 'red',
                'popularity' => 95,
                'founded' => '1953-01-07',
                'description' => 'Fédération dominante dans les années 90, vit une transition entre la Golden Era et la New Generation Era',
                'image' => 'wwf.png',
            ],
            [
                'name' => 'WCW',
                'owner' => 'Ted Turner',
                'booker' => 'Eric Bischoff',
                'based_in' => 'Atlanta',
                'country' => 'USA',
                'money' => 900000,
                'style' => BrandStyle::style3,
                'color' => 'orange',
                'popularity' => 85,
                'founded' => '1988-10-01',
                'description' => 'Rivale de la WWF, innovatrice avec Nitro et la nWo en 1996',
                'image' => 'wcw.png',
            ],
            [
                'name' => 'ECW',
                'owner' => 'Paul Heyman',
                'booker' => 'Paul Heyman',
                'based_in' => 'Philadelphia',
                'country' => 'USA',
                'money' => 250000,
                'style' => BrandStyle::style4,
                'color' => 'purple',
                'popularity' => 70,
                'founded' => '1992-04-25',
                'description' => 'Fédération culte hardcore, pionnière du style réaliste et extrême',
                'image' => 'ecw.png',
            ],
            [
                'name' => 'USWA',
                'owner' => 'Jerry Jarrett',
                'booker' => 'Jerry Lawler',
                'based_in' => 'Memphis',
                'country' => 'USA',
                'money' => 150000,
                'style' => BrandStyle::style2,
                'color' => 'gray',
                'popularity' => 50,
                'founded' => '1989-01-01',
                'description' => 'Dernier bastion du catch territorial du sud des USA',
                'image' => 'uswa.png',
            ],
            [
                'name' => 'SMW',
                'owner' => 'Jim Cornette',
                'booker' => 'Jim Cornette',
                'based_in' => 'Knoxville',
                'country' => 'USA',
                'money' => 120000,
                'style' => BrandStyle::style2,
                'color' => 'green',
                'popularity' => 45,
                'founded' => '1991-10-30',
                'description' => 'Promotion old-school du sud-est avec un public fidèle',
                'image' => 'smw.png',
            ],
            [
                'name' => 'NWA',
                'owner' => 'Dennis Coralluzzo',
                'booker' => 'Dennis Coralluzzo',
                'based_in' => 'Cherry Hill',
                'country' => 'USA',
                'money' => 180000,
                'style' => BrandStyle::style2,
                'color' => 'yellow',
                'popularity' => 50,
                'founded' => '1948-07-14',
                'description' => 'Fédération historique en perte de vitesse dans les années 90, mais toujours active via des promotions affiliées',
                'image' => 'nwa.png',
            ],
        ];

        foreach ($brands as $data) {
            Brand::create(array_merge($data, ['user_id' => $user->id]));
        }
    }
}
