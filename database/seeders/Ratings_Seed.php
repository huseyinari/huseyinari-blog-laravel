<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;

class Ratings_Seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rating = new Rating();
        $rating->postId = 1;
        $rating->userId = 1;
        $rating->star = 5;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 2;
        $rating->userId = 1;
        $rating->star = 5;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 3;
        $rating->userId = 1;
        $rating->star = 3;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 1;
        $rating->userId = 2;
        $rating->star = 5;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 2;
        $rating->userId = 2;
        $rating->star = 3;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 3;
        $rating->userId = 2;
        $rating->star = 1;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 4;
        $rating->userId = 1;
        $rating->star = 3;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 5;
        $rating->userId = 2;
        $rating->star = 1;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 6;
        $rating->userId = 1;
        $rating->star = 5;
        $rating->save();

        $rating = new Rating();
        $rating->postId = 4;
        $rating->userId = 2;
        $rating->star = 4;
        $rating->save();
    }
}
