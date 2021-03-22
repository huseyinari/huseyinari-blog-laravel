<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(7);
        return [
            'title' => $title,
            'coverPhoto' => 'https://www.wallpapertip.com/wmimgs/85-851874_the-new-cisco-crosswork-network-automation-software-cisco.jpg',
            'postOwner' => 1,
            'viewCount' => rand(0,100),
            'postContent' => $this->faker->randomHtml(),
            'categoryId' => rand(1,13),
            'seo' => Str::slug($title)
        ];
    }
}
