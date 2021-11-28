<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities =[
            [
              'city_id'=>1,
              'city_name'=>'Chennai',
            ],
            [
              'city_id'=>2,
              'city_name'=>'Bangalore'
            ],
            [
              'city_id'=>3,
              'city_name'=>'Coimbatore',
            ],
            [
              'city_id'=>4,
              'city_name'=>'Hydreabad'
            ],
            [
              'city_id'=>5,
              'city_name'=>'Mumbai',
            ],
            [
              'city_id'=>6,
              'city_name'=>'Pune'
            ],
            [
              'city_id'=>7,
              'city_name'=>'Thane',
            ],
            [
              'city_id'=>8,
              'city_name'=>'Gujarat'
            ],
            [
              'city_id'=>9,
              'city_name'=>'Kochin',
            ],
            [
              'city_id'=>10,
              'city_name'=>'Punjab'
            ],
        ];
        Location::insert($cities);
    }
}
