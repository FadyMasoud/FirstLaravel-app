<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class showroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('showrooms')->insert([
            'name' => 'Showroom 1',
            'address' => 'Jl. Jendral Sudirman No. 1',
            'contact_number' => '081234567890',
            'email' => 'pKwGd@example.com',
        ]);
        DB::table('showrooms')->insert([
            'name' => 'Showroom 2',
            'address' => 'Jl. Jendral Sudirman No. 2',
            'contact_number' => '081234567891',
            'email' => 'pKwGd@example.com',
        ]);
        DB::table('showrooms')->insert([
            'name' => 'Showroom 3',
            'address' => 'Jl. Jendral Sudirman No. 3',
            'contact_number' => '081234567892',
            'email' => 'pKwGd@example.com',
        ]);
        DB::table('showrooms')->insert([
            'name' => 'Showroom 4',
            'address' => 'Jl. Jendral Sudirman No. 4',
            'contact_number' => '081234567893',
            'email' => 'pKwGd@example.com',
        ]);
        DB::table('showrooms')->insert([
            'name' => 'Showroom 5',
            'address' => 'Jl. Jendral Sudirman No. 5',
            'contact_number' => '081234567894',
            'email' => 'pKwGd@example.com',
        ]);
        


    }
}
