<?php

namespace Database\Seeders;

use App\Enums\WorkerCategory;
use App\Enums\WorkerGender;
use App\Enums\WorkerStatus;
use App\Enums\WorkerStyle;
use App\Models\GameSession;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $session = GameSession::firstOrCreate([
            'user_id' => $user->id,
            'name' => 'Session Test',
        ]);
        $workers = [
            ["André", "Roussimoff", "The Giant", 90, 70, 60, 91, 224, WorkerStyle::brawler->value],
            ["Arn", "Anderson", "The Enforcer", 83, 65, 72, 180, 110, WorkerStyle::technician->value],
            ["Barry", "Windham", "", 85, 72, 75, 198, 115, WorkerStyle::specialist->value],
            ["Bobby", "Eaton", "", 80, 66, 68, 180, 100, WorkerStyle::highflyer->value],
            ["Bret", "Hart", "The Hitman", 86, 85, 80, 183, 106, WorkerStyle::technician->value],
            ["Davey Boy", "Smith", "British Bulldog", 84, 70, 72, 180, 120, WorkerStyle::powerhouse->value],
            ["Bruno", "Sammartino", "", 91, 88, 70, 178, 120, WorkerStyle::brawler->value],
            ["Frank", "Goodish", "Bruiser Brody", 87, 84, 74, 200, 123, WorkerStyle::brawler->value],
            ["Dory", "Funk Jr.", "", 85, 87, 60, 185, 110, WorkerStyle::technician->value],
            ["Dusty", "Rhodes", "American Dream", 87, 82, 88, 185, 125, WorkerStyle::brawler->value],
            ["Tom", "Billington", "Dynamite Kid", 82, 85, 66, 172, 95, WorkerStyle::highflyer->value],
            ["Greg", "Valentine", "", 80, 83, 70, 183, 112, WorkerStyle::brawler->value],
            ["Harley", "Race", "", 88, 84, 76, 185, 109, WorkerStyle::specialist->value],
            ["Terry", "Bollea", "Hulk Hogan", 91, 92, 85, 201, 137, WorkerStyle::brawler->value],
            ["Ivan", "Koloff", "", 83, 82, 70, 180, 111, WorkerStyle::brawler->value],
            ["Jake", "Roberts", "The Snake", 84, 84, 84, 196, 111, WorkerStyle::specialist->value],
            ["Jerry", "Lawler", "The King", 82, 82, 88, 178, 105, WorkerStyle::specialist->value],
            ["Larry", "Zbyszko", "", 81, 80, 84, 180, 102, WorkerStyle::technician->value],
            ["Terry", "Allen", "Magnum T.A.", 81, 81, 80, 183, 104, WorkerStyle::powerhouse->value],
            ["Curt", "Hennig", "Mr. Perfect", 85, 85, 85, 188, 107, WorkerStyle::technician->value],
            ["Nikita", "Koloff", "", 84, 80, 66, 185, 125, WorkerStyle::powerhouse->value],
            ["Paul", "Orndorff", "Mr. Wonderful", 83, 81, 72, 183, 115, WorkerStyle::brawler->value],
            ["Randy", "Savage", "Macho Man", 86, 85, 87, 185, 107, WorkerStyle::specialist->value],
            ["Ric", "Flair", "Nature Boy", 89, 83, 93, 185, 108, WorkerStyle::technician->value],
            ["Rick", "Rude", "Ravishing", 84, 78, 84, 190, 110, WorkerStyle::powerhouse->value],
            ["Ricky", "Morton", "", 79, 76, 70, 180, 98, WorkerStyle::highflyer->value],
            ["Ricky", "Steamboat", "The Dragon", 85, 86, 85, 180, 100, WorkerStyle::technician->value],
            ["Robert", "Gibson", "", 78, 75, 65, 180, 100, WorkerStyle::specialist->value],
            ["Roddy", "Piper", "Hot Road", 85, 81, 91, 185, 107, WorkerStyle::brawler->value],
            ["Robert", "Remus", "Sgt. Slaughter", 82, 78, 76, 190, 120, WorkerStyle::brawler->value],
            ["Stan", "Lane", "", 77, 74, 72, 180, 102, WorkerStyle::technician->value],
            ["Steve", "Borden", "Sting", 89, 85, 88, 190, 111, WorkerStyle::specialist->value],
            ["Billy", "Graham", "Superstar", 86, 79, 92, 190, 123, WorkerStyle::powerhouse->value],
            ["Ted", "DiBiase", "Million Dollar Man", 87, 84, 86, 190, 108, WorkerStyle::technician->value],
            ["Terry", "Funk", "", 86, 86, 87, 185, 108, WorkerStyle::brawler->value],
            ["Tony", "Atlas", "", 78, 78, 66, 180, 115, WorkerStyle::powerhouse->value],
            ["Shawn", "Michaels", "HBK", 89, 84, 90, 185, 103, WorkerStyle::highflyer->value],
            ["Kevin", "Nash", "Diesel", 85, 75, 70, 208, 138, WorkerStyle::powerhouse->value],
            ["Scott", "Hall", "Razor Ramon", 86, 76, 80, 201, 123, WorkerStyle::brawler->value],
            ["Mark", "Calaway", "The Undertaker", 95, 90, 75, 208, 136, WorkerStyle::brawler->value],
            ["Rodney", "Anoa'i", "Yokozuna", 90, 60, 50, 193, 270, WorkerStyle::powerhouse->value],
            ["Owen", "Hart", "", 84, 82, 78, 178, 102, WorkerStyle::technician->value],
            ["Lex", "Luger", "", 83, 65, 72, 191, 120, WorkerStyle::powerhouse->value],
            ["Leon", "White", "Vader", 87, 68, 70, 193, 200, WorkerStyle::powerhouse->value],
            ["Sean", "Waltman", "1-2-3 Kid", 79, 70, 66, 175, 90, WorkerStyle::highflyer->value],
            ["Steve", "Austin", "Stone Cold", 86, 85, 85, 188, 114, WorkerStyle::brawler->value],
            ["Brian", "Pillman", "Flyin' Brian", 84, 74, 78, 180, 100, WorkerStyle::highflyer->value],
            ["Scott", "Levy", "Raven", 83, 70, 85, 185, 107, WorkerStyle::specialist->value],
            ["Terry", "Brunk", "Sabu", 83, 85, 60, 183, 100, WorkerStyle::highflyer->value],
            ["Peter", "Senerchia", "Taz", 82, 85, 68, 173, 108, WorkerStyle::brawler->value],
            ["Tommy", "Dreamer", "", 81, 80, 75, 183, 108, WorkerStyle::brawler->value],
            ["Bob", "Backlund", "", 82, 78, 72, 180, 100, WorkerStyle::technician->value],
            ["Sid", "Eudy", "Sid Justice", 86, 84, 65, 200, 125, WorkerStyle::powerhouse->value],
            ["Paul", "Levesque", "HHH", 83, 80, 74, 193, 115, WorkerStyle::technician->value],
            ["Debrah", "Miceli", "Alundra Blayze", 84, 76, 72, 170, 70, WorkerStyle::technician->value],
            ["Marc", "Mero", "Johnny B. Badd", 82, 78, 73, 180, 102, WorkerStyle::highflyer->value],
            ["Darren", "Matthews", "Lord Steven Regal", 83, 79, 81, 185, 110, WorkerStyle::technician->value],
            ["James", "Fullington", "The Sandman", 80, 75, 77, 185, 112, WorkerStyle::brawler->value],
            ["Mikey", "Whipwreck", "", 78, 77, 70, 175, 92, WorkerStyle::specialist->value],
            ["Jimmy", "Snuka", "The Super Fly", 81, 70, 75, 183, 108, WorkerStyle::highflyer->value],
            ["Don", "Muraco", "", 80, 70, 78, 188, 120, WorkerStyle::brawler->value],
            ["Jim", "Neidhart", "L'enclume", 80, 65, 76, 180, 125, WorkerStyle::powerhouse->value],
            ["Tito", "Santana", "", 82, 72, 78, 185, 104, WorkerStyle::technician->value],
            ["Sylvester", "Ritter", "Junkyard Dog", 82, 80, 70, 185, 120, WorkerStyle::brawler->value],
            ["George", "Steele", "The Animal", 78, 65, 65, 180, 120, WorkerStyle::brawler->value],
            ["Christopher", "Pallies", "King Kong Bundy", 84, 68, 74, 193, 204, WorkerStyle::powerhouse->value],
            ["Wayne", "Farris", "Honky Tonk Man", 80, 85, 68, 185, 108, WorkerStyle::specialist->value],
            ["Ray", "Traylor", "Big Boss Man", 84, 75, 76, 193, 138, WorkerStyle::powerhouse->value],
            ["Rick", "Martel", "", 82, 78, 74, 183, 103, WorkerStyle::technician->value],
            ["Jacques", "Rougeau", "The Mountie", 80, 75, 70, 183, 105, WorkerStyle::specialist->value],
            ["Chris", "Chavis", "Tatanka", 81, 72, 78, 185, 111, WorkerStyle::powerhouse->value],
            ["Matt", "Osborne", "Doink the Clown", 79, 74, 75, 183, 107, WorkerStyle::specialist->value],
            ["Charles", "Wright", "Papa Shango", 80, 73, 76, 193, 130, WorkerStyle::brawler->value],
            ["Bob", "Orton Jr.", "", 80, 72, 70, 185, 108, WorkerStyle::technician->value],
            ["Ron", "Simmons", "", 84, 75, 80, 188, 125, WorkerStyle::powerhouse->value],
            ["Michael", "Hayes", "", 81, 76, 72, 183, 102, WorkerStyle::specialist->value],
            ["Terry", "Gordy", "", 83, 74, 78, 190, 120, WorkerStyle::brawler->value],
            ["Bruce", "Reed", "Butch Reed", 81, 70, 75, 183, 113, WorkerStyle::powerhouse->value],
            ["Mick", "Foley", "Cactus Jack", 88, 80, 84, 188, 120, WorkerStyle::brawler->value],
            ["Chris", "Benoit", "", 87, 72, 88, 178, 100, WorkerStyle::technician->value],
            ["Dean", "Malenko", "", 86, 65, 90, 173, 95, WorkerStyle::technician->value],
            ["Eddie", "Guerrero", "", 88, 78, 86, 173, 95, WorkerStyle::highflyer->value],
            ["Troy", "Martin", "Shane Douglas", 83, 80, 80, 183, 107, WorkerStyle::specialist->value],
            ["Jerome", "Young", "New Jack", 75, 70, 70, 180, 100, WorkerStyle::brawler->value],
            ["Brian", "Knighton", "Axl Rotten", 74, 66, 68, 180, 104, WorkerStyle::brawler->value],
            ["Bill", "Eadie", "Demolition Ax", 81, 72, 74, 188, 127, WorkerStyle::powerhouse->value],
            ["Barry", "Darsow", "Demolition Smash", 80, 70, 73, 185, 122, WorkerStyle::brawler->value],
            ["Butch", "", "Bushwhacker Butch", 76, 68, 68, 180, 102, WorkerStyle::specialist->value],
            ["Luke", "", "Bushwhacker Luke", 76, 68, 68, 180, 102, WorkerStyle::specialist->value],
            ["Sam", "Fatu", "Samu", 78, 65, 72, 185, 125, WorkerStyle::brawler->value],
            ["Solofa", "Fatu", "Fatu", 79, 68, 74, 185, 130, WorkerStyle::powerhouse->value]
        ];

        foreach ($workers as [$firstname, $lastname,$nickname, $overall, $promo, $endurance, $height, $weight, $style]) {
            Worker::create([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'nickname' => $nickname,
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
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'note' => null,
                'user_id' => $user->id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);
        }
    }
}
