<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
// use App\Models\Comment;
use Illuminate\Support\str;


class MakePostsCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::create([
            'title' => Str::random(10),
            'body' => Str::random(400),
            'user_id' => 1
        ]);

        // $comments = Comment::create([
        //     'body' => Str::random(400),
        //     'user_id' => 1,
        //     'post_id' => $posts->id
        // ]);  
        for ($i = 0; $i < 5; $i++) {
            $posts->comments()->create([

                'body' => Str::random(400),
                'user_id' => 1

            ]);
        }
    }
}
