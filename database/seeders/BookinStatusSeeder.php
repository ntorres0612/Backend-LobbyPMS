<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookinStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('booking_status')->truncate();

        $status =  [
            ['status' => 'Provisional',],
            ['status' => 'Confirmada',],
            ['status' => 'Cancelada']
        ];

        DB::table('booking_status')->insert($status);
    }
}
