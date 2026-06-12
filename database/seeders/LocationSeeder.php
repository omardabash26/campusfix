<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Device;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name'     => 'כיתה 101',
                'building' => 'בניין א',
                'floor'    => 'קומה 1',
            ],
            [
                'name'     => 'כיתה 202',
                'building' => 'בניין א',
                'floor'    => 'קומה 2',
            ],
            [
                'name'     => 'מעבדת מחשבים 1',
                'building' => 'בניין ב',
                'floor'    => 'קומה 1',
            ],
            [
                'name'     => 'אולם הרצאות גדול',
                'building' => 'בניין ג',
                'floor'    => 'קומה קרקע',
            ],
            [
                'name'     => 'חדר מורים',
                'building' => 'בניין א',
                'floor'    => 'קומה 3',
            ],
        ];

        foreach ($locations as $data) {
            $location = Location::create($data); // qr_token auto-generated in model boot()

            // Add a projector and AC to each location as sample devices
            Device::create([
                'name'        => 'מקרן',
                'type'        => 'מקרן',
                'location_id' => $location->id,
            ]);

            Device::create([
                'name'        => 'מזגן',
                'type'        => 'מזגן',
                'location_id' => $location->id,
            ]);
        }
    }
}