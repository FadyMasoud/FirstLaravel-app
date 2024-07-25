<?php

namespace Database\Seeders;

// use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some categories
        // $categories = Category::factory()->count(5)->create();
        // // Create some products


        // // Create some products for each category
        // $categories->each(function ($category) {
        //     Product::factory()->count(5)->create([
        //         'category_id' => $category->id,
        //     ]);
        // });
        // Category::create([
        //     'name' => Str::random(10),
        //     'pd_name' => Str::random(10),
        //     'images' => Str::random(10),
        //     'description' => Str::random(40),
        //     'price' => rand(100, 1000),
        //     'speed' => rand(1, 10),
        //     'type' => Str::random(10)
        // ]);

        // for ($i = 0; $i < 5; $i++) {
        Product::create([
            'id_category' => 3,
            'id_showroom' => 1,
            'name' => Str::random(10),
            'images' => Str::random(10),
            'description' => Str::random(40),
            'price' => rand(100, 1000),
            'speed' => rand(1, 10),
            'type' => Str::random(10),
            'cylinder' => Str::random(10),
            'color' => Str::random(10),
            'brand' => Str::random(10),
            'model' => Str::random(10),
            'offer' => rand(0, 100) / 100.0,
        ]);
        // }
    }
}
