<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrackingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('tracking_status')->insert([
            ['name' => 'Confirmed'],
            ['name' => 'Processing'],
            ['name' => 'Packed'],
            ['name' => 'Out for Delivery'],
            ['name' => 'Delivered'],
            ['name' => 'Cancelled'],
            ['name' => 'Return Requested'],
            ['name' => 'Return'],
        ]);
    }
}
