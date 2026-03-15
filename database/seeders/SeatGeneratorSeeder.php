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
        $aircrafts = Aircraft::all();
        
        foreach ($aircrafts as $aircraft) {
            $this->generateSeats($aircraft);
        }
    }
    
    private function generateSeats($aircraft)
    {
        // Restore template relation logic with safe fallback
        $template = $aircraft->template;
        
        if ($template) {
            $seatMap = [
                'rows' => $template->total_rows,
                'seats_per_row' => $template->seat_map['seats_per_row'] ?? ['A', 'B', 'C', 'D', 'E', 'F'],
                'business_rows' => $template->seat_map['business_rows'] ?? [1, 2, 3],
                'economy_rows' => $template->seat_map['economy_rows'] ?? range(4, $template->total_rows),
            ];
        } else {
            $seatMap = [
                'rows' => 30,
                'seats_per_row' => ['A', 'B', 'C', 'D', 'E', 'F'],
                'business_rows' => [1, 2, 3],
                'economy_rows' => range(4, 30),
            ];
        }

        
        // Hapus seats lama jika ada
        Seat::where('aircraft_id', $aircraft->aircraft_id)->delete();
        
        // Generate seats baru
        $seats = [];
        
        for ($row = 1; $row <= $seatMap['rows']; $row++) {
            foreach ($seatMap['seats_per_row'] as $seatLetter) {
                $seatClass = $this->determineSeatClass($row, $aircraft, $seatMap);
                
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
    
    private function determineSeatClass($row, $aircraft, $seatMap)
    {
        if (in_array($row, $seatMap['business_rows'] ?? [])) {
            return 'business';
        }
        if ($aircraft->preferred_zone_enabled && 
            $row >= $aircraft->preferred_zone_start_row && 
            $row <= $aircraft->preferred_zone_end_row) {
            return 'preferred';
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