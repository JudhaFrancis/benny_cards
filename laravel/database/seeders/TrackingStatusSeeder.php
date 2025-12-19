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

        DB::table('tracking_status')->truncate();
        // Insert new 12 records

        DB::table('tracking_status')->insert([
            ['title' => 'Order Details'],
            ['title' => 'Client Information'],
            ['title' => 'Card Specifications'],
            ['title' => 'Work Assign Process'],
            ['title' => 'Design – Checked & Given to Print'],
            ['title' => 'Order & Printing Status'],
            ['title' => 'Packaging & Logistics'],
            ['title' => 'Packaging Status'],
            ['title' => 'Delivery Location'],
            ['title' => 'Mode of Dispatch'],
            ['title' => 'Dispatch Details'],
            ['title' => 'Payment'],
        ]);
    }
}
