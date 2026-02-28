<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aircraft;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class SeatGeneratorSeeder extends Seeder
{
    public function run()
    {
        $aircrafts = Aircraft::with('template')->get();
        
        foreach ($aircrafts as $aircraft) {
            if ($aircraft->template) {
                $this->generateSeatsFromTemplate($aircraft);
            }
        }
    }
    
    private function generateSeatsFromTemplate($aircraft)
    {
        $template = $aircraft->template;
        $seatMap = $template->seat_map; // Sudah array karena casting
        
        // Hapus seats lama jika ada
        Seat::where('aircraft_id', $aircraft->aircraft_id)->delete();
        
        // Generate seats baru
        $seats = [];
        
        for ($row = 1; $row <= $seatMap['rows']; $row++) {
            foreach ($seatMap['seats_per_row'] as $seatLetter) {
                $seatClass = $this->determineSeatClass($row, $seatMap);
                
                $seats[] = [
                    'aircraft_id' => $aircraft->aircraft_id,
                    'seat_number' => $row . $seatLetter,
                    'seat_class' => $seatClass,
                    'seat_type' => $this->determineSeatType($seatLetter, $seatMap['seats_per_row']),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        // Insert dalam batch
        foreach (array_chunk($seats, 50) as $chunk) {
            Seat::insert($chunk);
        }
        
        $this->command->info("Generated " . count($seats) . " seats for {$aircraft->aircraft_model}");
    }
    
    private function determineSeatClass($row, $seatMap)
    {
        if (in_array($row, $seatMap['business_rows'] ?? [])) {
            return 'business';
        }
        if (in_array($row, $seatMap['economy_rows'] ?? [])) {
            return 'economy';
        }
        return 'economy';
    }
    
    private function determineSeatType($seatLetter, $seatsPerRow)
    {
        $index = array_search($seatLetter, $seatsPerRow);
        $total = count($seatsPerRow);
        
        if ($index === 0 || $index === $total - 1) {
            return 'window';
        } elseif ($index === floor($total / 2) - 1 || $index === floor($total / 2)) {
            return 'middle';
        }
        return 'aisle';
    }
}