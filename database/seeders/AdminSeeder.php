<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'avoinexadmin@gmail.com';

        $exists = \App\Models\Admin::where('email', $email)->exists();

        if (!$exists) {
            \App\Models\Admin::create([
                'name' => 'Avoinex Admin',
                'email' => $email,
                'password' => bcrypt('avoinexadmin')
            ]);

            $this->command->info('✅ Admin user created successfully!');
        } else {
            $this->command->info('ℹ️ Admin user already exists.');
        }
    }
}
