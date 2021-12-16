<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        // For add 12 users
        $count_users = 12;

        // Use progress
        $this->command->getOutput()->progressStart($count_users);

        for($i = 0; $i < $count_users; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(8),
                'email' => Str::lower(Str::random(8)) . '@gmail.com',
                'password' => Hash::make('12345678'),
                'api_token' => Hash::make('token'),
            ]);
            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
    }
}
