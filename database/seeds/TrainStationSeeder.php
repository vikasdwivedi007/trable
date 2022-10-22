<?php

use Illuminate\Database\Seeder;

class TrainStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stations = ["Cairo", "Giza", "Aswan", "Luxor", "Alexandria", "Marsa Matruh", "Ismailia", "Sohag", "Asyut", "Itay Al Barud", "Zagazig", "Suez", "Faiyum", "El-Mahalla", "Mansoura", "Minya", "Banha", "Beni Suef", "Port Said", "Damanhour", "Damietta", "Tanta", "Qena", "Kafr El Sheikh"];
        $order = 1;
        foreach($stations as $station){
            if(!\App\Models\TrainStation::where('name', $station)->count()){
                $new = new \App\Models\TrainStation();
                $new->order_col = $order;
                $new->name = $station;
                $new->save();
            }
            $order++;
        }
    }
}
