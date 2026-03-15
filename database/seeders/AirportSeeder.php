<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            // Indonesia - Major Hubs & Tourist Destinations
            ['iata' => 'CGK', 'city' => 'Jakarta', 'name' => 'Soekarno-Hatta International Airport', 'country' => 'ID'],
            ['iata' => 'HLP', 'city' => 'Jakarta', 'name' => 'Halim Perdanakusuma International Airport', 'country' => 'ID'],
            ['iata' => 'DPS', 'city' => 'Denpasar', 'name' => 'Ngurah Rai International Airport', 'country' => 'ID'],
            ['iata' => 'SUB', 'city' => 'Surabaya', 'name' => 'Juanda International Airport', 'country' => 'ID'],
            ['iata' => 'KNO', 'city' => 'Medan', 'name' => 'Kualanamu International Airport', 'country' => 'ID'],
            ['iata' => 'UPG', 'city' => 'Makassar', 'name' => 'Sultan Hasanuddin International Airport', 'country' => 'ID'],
            ['iata' => 'BPN', 'city' => 'Balikpapan', 'name' => 'Sultan Aji Muhammad Sulaiman International Airport', 'country' => 'ID'],
            ['iata' => 'YIA', 'city' => 'Yogyakarta', 'name' => 'Yogyakarta International Airport', 'country' => 'ID'],
            ['iata' => 'JOG', 'city' => 'Yogyakarta', 'name' => 'Adisutjipto International Airport', 'country' => 'ID'],
            ['iata' => 'SRG', 'city' => 'Semarang', 'name' => 'Jenderal Ahmad Yani International Airport', 'country' => 'ID'],
            ['iata' => 'BTH', 'city' => 'Batam', 'name' => 'Hang Nadim International Airport', 'country' => 'ID'],
            ['iata' => 'PLM', 'city' => 'Palembang', 'name' => 'Sultan Mahmud Badaruddin II International Airport', 'country' => 'ID'],
            ['iata' => 'PKU', 'city' => 'Pekanbaru', 'name' => 'Sultan Syarif Kasim II International Airport', 'country' => 'ID'],
            ['iata' => 'BDO', 'city' => 'Bandung', 'name' => 'Husein Sastranegara International Airport', 'country' => 'ID'],
            ['iata' => 'KJT', 'city' => 'Majalengka', 'name' => 'Kertajati International Airport', 'country' => 'ID'],
            ['iata' => 'LOP', 'city' => 'Lombok', 'name' => 'Lombok International Airport', 'country' => 'ID'],
            ['iata' => 'PDG', 'city' => 'Padang', 'name' => 'Minangkabau International Airport', 'country' => 'ID'],
            ['iata' => 'MDC', 'city' => 'Manado', 'name' => 'Sam Ratulangi International Airport', 'country' => 'ID'],
            ['iata' => 'PNK', 'city' => 'Pontianak', 'name' => 'Supadio International Airport', 'country' => 'ID'],
            ['iata' => 'SOC', 'city' => 'Solo', 'name' => 'Adisumarmo International Airport', 'country' => 'ID'],
            ['iata' => 'AAP', 'city' => 'Samarinda', 'name' => 'Aji Pangeran Tumenggung Pranoto International Airport', 'country' => 'ID'],
            ['iata' => 'BDJ', 'city' => 'Banjarmasin', 'name' => 'Syamsudin Noor International Airport', 'country' => 'ID'],
            ['iata' => 'AMQ', 'city' => 'Ambon', 'name' => 'Pattimura International Airport', 'country' => 'ID'],
            ['iata' => 'DJJ', 'city' => 'Jayapura', 'name' => 'Sentani International Airport', 'country' => 'ID'],
            ['iata' => 'SOQ', 'city' => 'Sorong', 'name' => 'Domine Eduard Osok Airport', 'country' => 'ID'],
            ['iata' => 'TIM', 'city' => 'Timika', 'name' => 'Mozes Kilangin Airport', 'country' => 'ID'],
            ['iata' => 'TKG', 'city' => 'Bandar Lampung', 'name' => 'Radin Inten II International Airport', 'country' => 'ID'],
            ['iata' => 'PGK', 'city' => 'Pangkal Pinang', 'name' => 'Depati Amir Airport', 'country' => 'ID'],
            ['iata' => 'TJQ', 'city' => 'Tanjung Pandan', 'name' => 'H.A.S. Hanandjoeddin Airport', 'country' => 'ID'],
            ['iata' => 'DTB', 'city' => 'Silangit', 'name' => 'Sisingamangaraja XII International Airport', 'country' => 'ID'],

            // Southeast Asia
            ['iata' => 'SIN', 'city' => 'Singapore', 'name' => 'Changi International Airport', 'country' => 'SG'],
            ['iata' => 'KUL', 'city' => 'Kuala Lumpur', 'name' => 'Kuala Lumpur International Airport', 'country' => 'MY'],
            ['iata' => 'PEN', 'city' => 'Penang', 'name' => 'Penang International Airport', 'country' => 'MY'],
            ['iata' => 'BKK', 'city' => 'Bangkok', 'name' => 'Suvarnabhumi Airport', 'country' => 'TH'],
            ['iata' => 'DMK', 'city' => 'Bangkok', 'name' => 'Don Mueang International Airport', 'country' => 'TH'],
            ['iata' => 'SGN', 'city' => 'Ho Chi Minh City', 'name' => 'Tan Son Nhat International Airport', 'country' => 'VN'],
            ['iata' => 'HAN', 'city' => 'Hanoi', 'name' => 'Noi Bai International Airport', 'country' => 'VN'],
            ['iata' => 'MNL', 'city' => 'Manila', 'name' => 'Ninoy Aquino International Airport', 'country' => 'PH'],
            ['iata' => 'CEB', 'city' => 'Cebu', 'name' => 'Mactan-Cebu International Airport', 'country' => 'PH'],
            ['iata' => 'HKT', 'city' => 'Phuket', 'name' => 'Phuket International Airport', 'country' => 'TH'],
            ['iata' => 'RGN', 'city' => 'Yangon', 'name' => 'Yangon International Airport', 'country' => 'MM'],
            ['iata' => 'PNH', 'city' => 'Phnom Penh', 'name' => 'Phnom Penh International Airport', 'country' => 'KH'],

            // East Asia
            ['iata' => 'NRT', 'city' => 'Tokyo', 'name' => 'Narita International Airport', 'country' => 'JP'],
            ['iata' => 'HND', 'city' => 'Tokyo', 'name' => 'Haneda Airport', 'country' => 'JP'],
            ['iata' => 'KIX', 'city' => 'Osaka', 'name' => 'Kansai International Airport', 'country' => 'JP'],
            ['iata' => 'NGO', 'city' => 'Nagoya', 'name' => 'Chubu Centrair International Airport', 'country' => 'JP'],
            ['iata' => 'FUK', 'city' => 'Fukuoka', 'name' => 'Fukuoka Airport', 'country' => 'JP'],
            ['iata' => 'CTS', 'city' => 'Sapporo', 'name' => 'New Chitose Airport', 'country' => 'JP'],
            ['iata' => 'ICN', 'city' => 'Seoul', 'name' => 'Incheon International Airport', 'country' => 'KR'],
            ['iata' => 'GMP', 'city' => 'Seoul', 'name' => 'Gimpo International Airport', 'country' => 'KR'],
            ['iata' => 'CJU', 'city' => 'Jeju', 'name' => 'Jeju International Airport', 'country' => 'KR'],
            ['iata' => 'PEK', 'city' => 'Beijing', 'name' => 'Beijing Capital International Airport', 'country' => 'CN'],
            ['iata' => 'PKX', 'city' => 'Beijing', 'name' => 'Beijing Daxing International Airport', 'country' => 'CN'],
            ['iata' => 'PVG', 'city' => 'Shanghai', 'name' => 'Shanghai Pudong International Airport', 'country' => 'CN'],
            ['iata' => 'SHA', 'city' => 'Shanghai', 'name' => 'Shanghai Hongqiao International Airport', 'country' => 'CN'],
            ['iata' => 'CAN', 'city' => 'Guangzhou', 'name' => 'Guangzhou Baiyun International Airport', 'country' => 'CN'],
            ['iata' => 'SZX', 'city' => 'Shenzhen', 'name' => 'Shenzhen Bao\'an International Airport', 'country' => 'CN'],
            ['iata' => 'HKG', 'city' => 'Hong Kong', 'name' => 'Hong Kong International Airport', 'country' => 'HK'],
            ['iata' => 'MFM', 'city' => 'Macau', 'name' => 'Macau International Airport', 'country' => 'MO'],
            ['iata' => 'TPE', 'city' => 'Taipei', 'name' => 'Taoyuan International Airport', 'country' => 'TW'],
            ['iata' => 'KHH', 'city' => 'Kaohsiung', 'name' => 'Kaohsiung International Airport', 'country' => 'TW'],

            // Middle East
            ['iata' => 'DXB', 'city' => 'Dubai', 'name' => 'Dubai International Airport', 'country' => 'AE'],
            ['iata' => 'AUH', 'city' => 'Abu Dhabi', 'name' => 'Zayed International Airport', 'country' => 'AE'],
            ['iata' => 'SHJ', 'city' => 'Sharjah', 'name' => 'Sharjah International Airport', 'country' => 'AE'],
            ['iata' => 'DOH', 'city' => 'Doha', 'name' => 'Hamad International Airport', 'country' => 'QA'],
            ['iata' => 'JED', 'city' => 'Jeddah', 'name' => 'King Abdulaziz International Airport', 'country' => 'SA'],
            ['iata' => 'RUH', 'city' => 'Riyadh', 'name' => 'King Khalid International Airport', 'country' => 'SA'],
            ['iata' => 'DMM', 'city' => 'Dammam', 'name' => 'King Fahd International Airport', 'country' => 'SA'],
            ['iata' => 'IST', 'city' => 'Istanbul', 'name' => 'Istanbul Airport', 'country' => 'TR'],
            ['iata' => 'SAW', 'city' => 'Istanbul', 'name' => 'Sabiha Gökçen International Airport', 'country' => 'TR'],
            ['iata' => 'MCT', 'city' => 'Muscat', 'name' => 'Muscat International Airport', 'country' => 'OM'],
            ['iata' => 'BAH', 'city' => 'Manama', 'name' => 'Bahrain International Airport', 'country' => 'BH'],

            // Oceania
            ['iata' => 'SYD', 'city' => 'Sydney', 'name' => 'Sydney Kingsford Smith Airport', 'country' => 'AU'],
            ['iata' => 'MEL', 'city' => 'Melbourne', 'name' => 'Melbourne Airport', 'country' => 'AU'],
            ['iata' => 'BNE', 'city' => 'Brisbane', 'name' => 'Brisbane Airport', 'country' => 'AU'],
            ['iata' => 'PER', 'city' => 'Perth', 'name' => 'Perth Airport', 'country' => 'AU'],
            ['iata' => 'ADL', 'city' => 'Adelaide', 'name' => 'Adelaide Airport', 'country' => 'AU'],
            ['iata' => 'CBR', 'city' => 'Canberra', 'name' => 'Canberra Airport', 'country' => 'AU'],
            ['iata' => 'AKL', 'city' => 'Auckland', 'name' => 'Auckland Airport', 'country' => 'NZ'],
            ['iata' => 'WLG', 'city' => 'Wellington', 'name' => 'Wellington International Airport', 'country' => 'NZ'],
            ['iata' => 'CHC', 'city' => 'Christchurch', 'name' => 'Christchurch International Airport', 'country' => 'NZ'],

            // Europe
            ['iata' => 'LHR', 'city' => 'London', 'name' => 'Heathrow Airport', 'country' => 'GB'],
            ['iata' => 'LGW', 'city' => 'London', 'name' => 'Gatwick Airport', 'country' => 'GB'],
            ['iata' => 'CDG', 'city' => 'Paris', 'name' => 'Charles de Gaulle Airport', 'country' => 'FR'],
            ['iata' => 'ORY', 'city' => 'Paris', 'name' => 'Orly Airport', 'country' => 'FR'],
            ['iata' => 'FRA', 'city' => 'Frankfurt', 'name' => 'Frankfurt Airport', 'country' => 'DE'],
            ['iata' => 'MUC', 'city' => 'Munich', 'name' => 'Munich Airport', 'country' => 'DE'],
            ['iata' => 'BER', 'city' => 'Berlin', 'name' => 'Berlin Brandenburg Airport', 'country' => 'DE'],
            ['iata' => 'AMS', 'city' => 'Amsterdam', 'name' => 'Amsterdam Airport Schiphol', 'country' => 'NL'],
            ['iata' => 'MAD', 'city' => 'Madrid', 'name' => 'Adolfo Suárez Madrid–Barajas Airport', 'country' => 'ES'],
            ['iata' => 'BCN', 'city' => 'Barcelona', 'name' => 'Josep Tarradellas Barcelona–El Prat Airport', 'country' => 'ES'],
            ['iata' => 'FCO', 'city' => 'Rome', 'name' => 'Leonardo da Vinci–Fiumicino Airport', 'country' => 'IT'],
            ['iata' => 'MXP', 'city' => 'Milan', 'name' => 'Milan Malpensa Airport', 'country' => 'IT'],
            ['iata' => 'ZRH', 'city' => 'Zurich', 'name' => 'Zurich Airport', 'country' => 'CH'],
            ['iata' => 'VIE', 'city' => 'Vienna', 'name' => 'Vienna International Airport', 'country' => 'AT'],
            ['iata' => 'CPH', 'city' => 'Copenhagen', 'name' => 'Copenhagen Airport', 'country' => 'DK'],
            ['iata' => 'ARN', 'city' => 'Stockholm', 'name' => 'Stockholm Arlanda Airport', 'country' => 'SE'],
            ['iata' => 'OSL', 'city' => 'Oslo', 'name' => 'Oslo Gardermoen Airport', 'country' => 'NO'],
            ['iata' => 'HEL', 'city' => 'Helsinki', 'name' => 'Helsinki Airport', 'country' => 'FI'],
            ['iata' => 'SVO', 'city' => 'Moscow', 'name' => 'Sheremetyevo International Airport', 'country' => 'RU'],
            ['iata' => 'DME', 'city' => 'Moscow', 'name' => 'Domodedovo International Airport', 'country' => 'RU'],

            // North America
            ['iata' => 'JFK', 'city' => 'New York', 'name' => 'John F. Kennedy International Airport', 'country' => 'US'],
            ['iata' => 'EWR', 'city' => 'New York', 'name' => 'Newark Liberty International Airport', 'country' => 'US'],
            ['iata' => 'LAX', 'city' => 'Los Angeles', 'name' => 'Los Angeles International Airport', 'country' => 'US'],
            ['iata' => 'SFO', 'city' => 'San Francisco', 'name' => 'San Francisco International Airport', 'country' => 'US'],
            ['iata' => 'ORD', 'city' => 'Chicago', 'name' => 'O\'Hare International Airport', 'country' => 'US'],
            ['iata' => 'ATL', 'city' => 'Atlanta', 'name' => 'Hartsfield-Jackson Atlanta International Airport', 'country' => 'US'],
            ['iata' => 'DFW', 'city' => 'Dallas', 'name' => 'Dallas/Fort Worth International Airport', 'country' => 'US'],
            ['iata' => 'DEN', 'city' => 'Denver', 'name' => 'Denver International Airport', 'country' => 'US'],
            ['iata' => 'SEA', 'city' => 'Seattle', 'name' => 'Seattle-Tacoma International Airport', 'country' => 'US'],
            ['iata' => 'MIA', 'city' => 'Miami', 'name' => 'Miami International Airport', 'country' => 'US'],
            ['iata' => 'LAS', 'city' => 'Las Vegas', 'name' => 'Harry Reid International Airport', 'country' => 'US'],
            ['iata' => 'BOS', 'city' => 'Boston', 'name' => 'Logan International Airport', 'country' => 'US'],
            ['iata' => 'IAD', 'city' => 'Washington, D.C.', 'name' => 'Washington Dulles International Airport', 'country' => 'US'],
            ['iata' => 'YVR', 'city' => 'Vancouver', 'name' => 'Vancouver International Airport', 'country' => 'CA'],
            ['iata' => 'YYZ', 'city' => 'Toronto', 'name' => 'Toronto Pearson International Airport', 'country' => 'CA'],
            ['iata' => 'YUL', 'city' => 'Montreal', 'name' => 'Montréal-Pierre Elliott Trudeau International Airport', 'country' => 'CA'],
            ['iata' => 'MEX', 'city' => 'Mexico City', 'name' => 'Mexico City International Airport', 'country' => 'MX'],
            ['iata' => 'CUN', 'city' => 'Cancún', 'name' => 'Cancún International Airport', 'country' => 'MX'],

            // South America
            ['iata' => 'GRU', 'city' => 'São Paulo', 'name' => 'São Paulo/Guarulhos International Airport', 'country' => 'BR'],
            ['iata' => 'GIG', 'city' => 'Rio de Janeiro', 'name' => 'Rio de Janeiro/Galeão International Airport', 'country' => 'BR'],
            ['iata' => 'EZE', 'city' => 'Buenos Aires', 'name' => 'Ministro Pistarini International Airport', 'country' => 'AR'],
            ['iata' => 'SCL', 'city' => 'Santiago', 'name' => 'Arturo Merino Benítez International Airport', 'country' => 'CL'],
            ['iata' => 'BOG', 'city' => 'Bogotá', 'name' => 'El Dorado International Airport', 'country' => 'CO'],
            ['iata' => 'LIM', 'city' => 'Lima', 'name' => 'Jorge Chávez International Airport', 'country' => 'PE'],

            // Africa
            ['iata' => 'JNB', 'city' => 'Johannesburg', 'name' => 'O. R. Tambo International Airport', 'country' => 'ZA'],
            ['iata' => 'CPT', 'city' => 'Cape Town', 'name' => 'Cape Town International Airport', 'country' => 'ZA'],
            ['iata' => 'NBO', 'city' => 'Nairobi', 'name' => 'Jomo Kenyatta International Airport', 'country' => 'KE'],
            ['iata' => 'ADD', 'city' => 'Addis Ababa', 'name' => 'Addis Ababa Bole International Airport', 'country' => 'ET'],
            ['iata' => 'CAI', 'city' => 'Cairo', 'name' => 'Cairo International Airport', 'country' => 'EG'],
            ['iata' => 'CMN', 'city' => 'Casablanca', 'name' => 'Mohammed V International Airport', 'country' => 'MA'],
            ['iata' => 'LOS', 'city' => 'Lagos', 'name' => 'Murtala Muhammed International Airport', 'country' => 'NG'],
        ];

        // Unique countries for dynamic insertion
        $countries = [];
        foreach ($airports as $airport) {
            $countries[$airport['country']] = true;
        }

        foreach (array_keys($countries) as $countryCode) {
            \App\Models\Country::firstOrCreate(
                ['country_code' => $countryCode],
                ['country_name' => $countryCode, 'continent' => 'Unknown'] // Provide defaults
            );
        }

        foreach ($airports as $airport) {
            \App\Models\Airport::firstOrCreate(
                ['iata_code' => $airport['iata']],
                [
                    'airport_name' => $airport['name'],
                    'city' => $airport['city'],
                    'country_code' => $airport['country'],
                    'is_active' => true
                ]
            );
        }

        $this->command->info('✅ Airport Seeder finished - ' . count($airports) . ' global airports generated successfully!');
    }
}
