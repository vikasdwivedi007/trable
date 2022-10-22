<?php

use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //data
        $url = "https://raw.githubusercontent.com/hiiamrohit/Countries-States-Cities-database/master/states.json";
        $response = \Illuminate\Support\Facades\Http::withHeaders(['verify'=>false])->get($url);
        if(isset($response->json()['states'])){
            $data = $response->json()['states'];
            foreach ($data as $row){
                if(!\App\Models\City::where('name', $row['name'])->count()){
                    $c = new \App\Models\City();
                    $c->name = $row['name'];
                    $c->country_id = $row['country_id'];
                    $c->save();
                }
            }
        }else{
            echo 'invalid response';
        }
    }


    //full seeder

    //mini seeder
}
