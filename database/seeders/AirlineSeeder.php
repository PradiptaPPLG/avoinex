<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;

class AirlineSeeder extends Seeder
{
    public function run()
    {
        $airlines = [
            [
                'airline_code' => 'GA',
                'airline_name' => 'Garuda Indonesia',
                'country_code' => 'ID',
                'website' => 'https://www.garuda-indonesia.com',
                'contact_phone' => '+6221807007'
            ],
            [
                'airline_code' => 'QZ',
                'airline_name' => 'AirAsia',
                'country_code' => 'MY',
                'website' => 'https://www.airasia.com',
                'contact_phone' => '+60387754000'
            ],
            [
                'airline_code' => 'SQ',
                'airline_name' => 'Singapore Airlines',
                'country_code' => 'SG',
                'website' => 'https://www.singaporeair.com',
                'contact_phone' => '+6562238888'
            ],
            [
                'airline_code' => 'MH',
                'airline_name' => 'Malaysia Airlines',
                'country_code' => 'MY',
                'website' => 'https://www.malaysiaairlines.com',
                'contact_phone' => '+60378433000'
            ]
        ];

        foreach ($airlines as $airline) {
            Airline::create($airline);
        }
    }
}