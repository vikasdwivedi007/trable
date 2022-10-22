<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //data
        $url = "https://raw.githubusercontent.com/hiiamrohit/Countries-States-Cities-database/master/countries.json";
        $response = \Illuminate\Support\Facades\Http::withHeaders(['verify'=>false])->get($url);
        if(isset($response->json()['countries'])){
            //data
            $data = $response->json()['countries'];
            foreach ($data as $row){
                if(!\App\Models\Country::where('name', $row['name'])->count()){
                    $c = new \App\Models\Country();
                    $c->name = $row['name'];
                    $c->sortname = $row['sortname'];
                    $c->phoneCode = $row['phoneCode'];
                    $c->save();
                }
            }
        }else{
            echo 'invalid response';
        }
    }
}
