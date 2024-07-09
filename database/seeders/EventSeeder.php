<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Event;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $roomSchedules = array_fill(1,25,[]);



        function isAvailable($roomSchedules, $roomId, $start, $end ) {
            foreach ($roomSchedules[$roomId] as $event) {
                if (($start < $event['end']) && ($end > $event['start'] ) ) {
                    return false;
                }
            }
            return true;
        }

        function genColorRand(){
            $numbers = range('0','9');
            $chars = range('a','f');
            $arrAll = array_merge($numbers,$chars);
            $hexColor = '#';
            for($i=0; $i<6; $i++){
               $char_key = array_rand($arrAll,1);
               $char = $arrAll[$char_key];
               $hexColor = $hexColor.$char;
            }
            return $hexColor;
        }

        for ($i = 0; $i < 20; $i++) {

            $name = $faker->unique()->words(4,true);
            $desc =  $faker->text(200);

            do {

                $start = Carbon::instance($faker->dateTimeBetween('now', '+1 month'))->format('Y-m-d');
                $end = (new Carbon($start))->addDays($faker->numberBetween(1, 8))->format('Y-m-d');
                $roomId = $faker->numberBetween(1, 25);
            } while (!isAvailable($roomSchedules, $roomId, $start, $end));

            $roomSchedules[$roomId][] = ['start' => $start, 'end' => $end];
            $color = genColorRand();
            Event::create( [
                "name" => $name,
                "slug"=>Str::slug($name,'-'),
                "description" => $desc,
                "image"=>null,
                "color"=> $color,
                "start_date" => $start,
                "end_date" => $end,
                "meeting_room_id" => $roomId
            ]);


        }


    }
}
