<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [];
        for ($i = 0; $i < 15; $i++) {
            $data[] = [
                'product_id' => rand(1, 10),
                'user_id' => rand(1, 3),
                'comment' => Str::random(10),
                'rating' => rand(1, 5)
            ];
        }
        
        DB::table('reviews')->insert($data);
    }
}
