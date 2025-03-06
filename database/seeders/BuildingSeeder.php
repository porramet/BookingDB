<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        $buildings = [
            [
                'building_name' => 'อาคาร A',
                'citizen_save' => 'สมชาย ใจดี',
                'image' => 'buildings/building_a.jpg'
            ],
            [
                'building_name' => 'อาคาร B', 
                'citizen_save' => 'สมหญิง ใจดี',
                'image' => 'buildings/building_b.jpg'
            ],
            [
                'building_name' => 'อาคาร C',
                'citizen_save' => 'สมปอง ใจดี',
                'image' => 'buildings/building_c.jpg'
            ],

        ];

        foreach ($buildings as $building) {
            Building::create($building);
        }
    }

}

