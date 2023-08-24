<?php

use App\City;
use App\Helper\Helper;
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
        $city = config('cities');

        foreach($city[ Helper::getCountry() ] as $c){
            City::create([ 'name' => $c ]);
        }
    }
}
