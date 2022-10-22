<?php

use App\Models\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = database_path() . DIRECTORY_SEPARATOR . 'seeds' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'airports.json';
        $data = file_get_contents($file);
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if (!Airport::where('icao', $value['icao'])->count()) {
                $airport = new Airport();
                $airport->icao = $value['icao'];
                $airport->iata = $value['iata'];
                $airport->name = $value['name'];
                $airport->city = $value['city'];
                $airport->state = $value['state'];
                $airport->country = $value['country'];
                $airport->timezone = $value['tz'];
                $airport->save();
            }
        }
    }
}
