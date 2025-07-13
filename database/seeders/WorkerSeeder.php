<?php

namespace Database\Seeders;

use App\Enums\WorkerCategory;
use App\Enums\WorkerGender;
use App\Enums\WorkerStatus;
use App\Enums\WorkerStyle;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $workers = [
            ["André", "the Giant", 90, 70, 60, 91, 224, WorkerStyle::brawler->value],
            ["Arn", "Anderson", 83, 65, 72, 180, 110, WorkerStyle::technician->value],
            ["Barry", "Windham", 85, 72, 75, 198, 115, WorkerStyle::specialist->value],
            ["Bobby", "Eaton", 80, 66, 68, 180, 100, WorkerStyle::highflyer->value],
            ["Bret", "Hart", 86, 85, 80, 183, 106, WorkerStyle::technician->value],
            ["British", "Bulldog", 84, 70, 72, 180, 120, WorkerStyle::powerhouse->value],
            ["Bruno", "Sammartino", 91, 88, 70, 178, 120, WorkerStyle::brawler->value],
            ["Bruiser", "Brody", 87, 84, 74, 200, 123, WorkerStyle::brawler->value],
            ["Dory", "Funk Jr.", 85, 87, 60, 185, 110, WorkerStyle::technician->value],
            ["Dusty", "Rhodes", 87, 82, 88, 185, 125, WorkerStyle::brawler->value],
            ["Dynamite", "Kid", 82, 85, 66, 172, 95, WorkerStyle::highflyer->value],
            ["Greg", "Valentine", 80, 83, 70, 183, 112, WorkerStyle::brawler->value],
            ["Harley", "Race", 88, 84, 76, 185, 109, WorkerStyle::specialist->value],
            ["Hulk", "Hogan", 91, 92, 85, 201, 137, WorkerStyle::brawler->value],
            ["Ivan", "Koloff", 83, 82, 70, 180, 111, WorkerStyle::brawler->value],
            ["Jake", "Roberts", 84, 84, 84, 196, 111, WorkerStyle::specialist->value],
            ["Jerry", "Lawler", 82, 82, 88, 178, 105, WorkerStyle::specialist->value],
            ["Larry", "Zbyszko", 81, 80, 84, 180, 102, WorkerStyle::technician->value],
            ["Magnum", "T.A.", 81, 81, 80, 183, 104, WorkerStyle::powerhouse->value],
            ["Mr.", "Perfect", 85, 85, 85, 188, 107, WorkerStyle::technician->value],
            ["Nikita", "Koloff", 84, 80, 66, 185, 125, WorkerStyle::powerhouse->value],
            ["Paul", "Orndorff", 83, 81, 72, 183, 115, WorkerStyle::brawler->value],
            ["Randy", "Savage", 86, 85, 87, 185, 107, WorkerStyle::specialist->value],
            ["Ric", "Flair", 89, 83, 93, 185, 108, WorkerStyle::technician->value],
            ["Rick", "Rude", 84, 78, 84, 190, 110, WorkerStyle::powerhouse->value],
            ["Ricky", "Morton", 79, 76, 70, 180, 98, WorkerStyle::highflyer->value],
            ["Ricky", "Steamboat", 85, 86, 85, 180, 100, WorkerStyle::technician->value],
            ["Robert", "Gibson", 78, 75, 65, 180, 100, WorkerStyle::specialist->value],
            ["Roddy", "Piper", 85, 81, 91, 185, 107, WorkerStyle::brawler->value],
            ["Sgt.", "Slaughter", 82, 78, 76, 190, 120, WorkerStyle::brawler->value],
            ["Stan", "Lane", 77, 74, 72, 180, 102, WorkerStyle::technician->value],
            ["Sting", "", 89, 85, 88, 190, 111, WorkerStyle::specialist->value],
            ["Superstar", "Billy Graham", 86, 79, 92, 190, 123, WorkerStyle::powerhouse->value],
            ["Ted", "DiBiase", 87, 84, 86, 190, 108, WorkerStyle::technician->value],
            ["Terry", "Funk", 86, 86, 87, 185, 108, WorkerStyle::brawler->value],
            ["Tony", "Atlas", 78, 78, 66, 180, 115, WorkerStyle::powerhouse->value],

            // 1991–1996 additions
            ["Shawn", "Michaels", 89, 84, 90, 185, 103, WorkerStyle::highflyer->value],
            ["Diesel", "", 85, 75, 70, 208, 138, WorkerStyle::powerhouse->value],
            ["Razor", "Ramon", 86, 76, 80, 201, 123, WorkerStyle::brawler->value],
            ["The", "Undertaker", 95, 90, 75, 208, 136, WorkerStyle::brawler->value],
            ["Yokozuna", "", 90, 60, 50, 193, 270, WorkerStyle::powerhouse->value],
            ["Owen", "Hart", 84, 82, 78, 178, 102, WorkerStyle::technician->value],
            ["Lex", "Luger", 83, 65, 72, 191, 120, WorkerStyle::powerhouse->value],
            ["Vader", "", 87, 68, 70, 193, 200, WorkerStyle::powerhouse->value],
            ["1-2-3", "Kid", 79, 70, 66, 175, 90, WorkerStyle::highflyer->value],
            ["Steve", "Austin", 86, 85, 85, 188, 114, WorkerStyle::brawler->value],
            ["Brian", "Pillman", 84, 74, 78, 180, 100, WorkerStyle::highflyer->value],
            ["Raven", "", 83, 70, 85, 185, 107, WorkerStyle::specialist->value],
            ["Sabu", "", 83, 85, 60, 183, 100, WorkerStyle::highflyer->value],
            ["Taz", "", 82, 85, 68, 173, 108, WorkerStyle::brawler->value],
            ["Tommy", "Dreamer", 81, 80, 75, 183, 108, WorkerStyle::brawler->value],
            ["Bob", "Backlund", 82, 78, 72, 180, 100, WorkerStyle::technician->value],
            ["Sid", "Justice", 86, 84, 65, 200, 125, WorkerStyle::powerhouse->value],
            ["Hunter", "Helmsley", 83, 80, 74, 193, 115, WorkerStyle::technician->value],
            ["Alundra", "Blayze", 84, 76, 72, 170, 70, WorkerStyle::technician->value],
            ["Johnny", "B. Badd", 82, 78, 73, 180, 102, WorkerStyle::highflyer->value],
            ["Lord", "Steven Regal", 83, 79, 81, 185, 110, WorkerStyle::technician->value],
            ["Sandman", "", 80, 75, 77, 185, 112, WorkerStyle::brawler->value],
            ["Mikey", "Whipwreck", 78, 77, 70, 175, 92, WorkerStyle::specialist->value],
        ];

        foreach ($workers as [$firstname, $lastname, $overall, $promo, $endurance, $height, $weight, $style]) {
            Worker::create([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'nickname' => null,
                'gender' => WorkerGender::male->value,
                'age' => rand(28, 52),
                'style' => $style,
                'status' => WorkerStatus::active->value,
                'category' => WorkerCategory::heavyweight->value,
                'height' => $height,
                'weight' => $weight,
                'image' => null,
                'overall' => $overall,
                'popularity' => rand(70, 95),
                'endurance' => $endurance,
                'promo_skill' => $promo,
                'wins' => rand(50, 300),
                'draws' => rand(0, 10),
                'losses' => rand(20, 120),
                'note' => null,
                'user_id' => $user->id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
