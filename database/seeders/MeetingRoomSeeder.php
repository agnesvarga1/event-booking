<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MeetingRoom;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class MeetingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i=0; $i<25;$i++){
            $meetingroom = new MeetingRoom();
            $meetingroom->name = 'Room-'.$faker->firstName();
            $meetingroom-> description = $faker->text(200);
            $meetingroom-> available_places = $faker->numberBetween(10,350);
            $meetingroom-> slug = Str::slug($meetingroom->name,'-');
            $meetingroom->save();
        }
    }
}
