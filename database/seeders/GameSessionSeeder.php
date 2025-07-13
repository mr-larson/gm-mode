<?php

namespace Database\Seeders;

use App\Models\GameSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameSessionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        GameSession::create([
            'user_id' => $user->id,
            'name' => 'Partie de test',
            'started_at' => now(),
            'is_active' => true,
        ]);
    }
}
