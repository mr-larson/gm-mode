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
                'name' => 'RAW',
                'owner' => 'WWE',
                'booker' => 'Triple H',
                'based_in' => 'New York',
                'country' => 'USA',
                'money' => 1000000,
                'style' => BrandStyle::style1,
                'color' => '#c50000',
                'popularity' => 90,
                'founded' => '1993-01-11',
                'description' => 'Le show phare de la WWE',
                'image' => 'raw.png',
            ],
            [
                'name' => 'SmackDown',
                'owner' => 'WWE',
                'booker' => 'Road Dogg',
                'based_in' => 'Los Angeles',
                'country' => 'USA',
                'money' => 900000,
                'style' => BrandStyle::style1,
                'color' => '#0055ff',
                'popularity' => 85,
                'founded' => '1999-04-29',
                'description' => 'Le show bleu de la WWE',
                'image' => 'smackdown.png',
            ],
            [
                'name' => 'NXT',
                'owner' => 'WWE',
                'booker' => 'Shawn Michaels',
                'based_in' => 'Orlando',
                'country' => 'USA',
                'money' => 500000,
                'style' => BrandStyle::style2,
                'color' => '#ffc107',
                'popularity' => 70,
                'founded' => '2012-06-20',
                'description' => 'Le centre de développement de la WWE',
                'image' => 'nxt.png',
            ],
            [
                'name' => 'AEW',
                'owner' => 'Tony Khan',
                'booker' => 'Tony Khan',
                'based_in' => 'Jacksonville',
                'country' => 'USA',
                'money' => 850000,
                'style' => BrandStyle::style6,
                'color' => '#ff6600',
                'popularity' => 80,
                'founded' => '2019-01-01',
                'description' => 'Promotion indépendante grandissante',
                'image' => 'aew.png',
            ],
            [
                'name' => 'TNA',
                'owner' => 'Anthem',
                'booker' => 'Scott D\'Amore',
                'based_in' => 'Nashville',
                'country' => 'USA',
                'money' => 400000,
                'style' => BrandStyle::style1,
                'color' => '#0099ff',
                'popularity' => 65,
                'founded' => '2002-06-19',
                'description' => 'Promotion qui a marqué les années 2000',
                'image' => 'tna.png',
            ],
            [
                'name' => 'WCW',
                'owner' => 'Ex Turner',
                'booker' => 'Eric Bischoff',
                'based_in' => 'Atlanta',
                'country' => 'USA',
                'money' => 700000,
                'style' => BrandStyle::style3,
                'color' => '#000000',
                'popularity' => 75,
                'founded' => '1988-10-01',
                'description' => 'Ancienne rivale de la WWE',
                'image' => 'wcw.png',
            ],
            [
                'name' => 'NWA',
                'owner' => 'Billy Corgan',
                'booker' => 'Billy Corgan',
                'based_in' => 'Atlanta',
                'country' => 'USA',
                'money' => 300000,
                'style' => BrandStyle::style3,
                'color' => '#990000',
                'popularity' => 50,
                'founded' => '1948-07-14',
                'description' => 'Fédération historique du catch',
                'image' => 'nwa.png',
            ],
            [
                'name' => 'ECW',
                'owner' => 'Paul Heyman',
                'booker' => 'Paul Heyman',
                'based_in' => 'Philadelphia',
                'country' => 'USA',
                'money' => 250000,
                'style' => BrandStyle::style4,
                'color' => '#660066',
                'popularity' => 60,
                'founded' => '1992-04-25',
                'description' => 'Fédération culte hardcore',
                'image' => 'ecw.png',
            ],
        ];

        foreach ($brands as $data) {
            Brand::create(array_merge($data, ['user_id' => $user->id]));
        }
    }
}
