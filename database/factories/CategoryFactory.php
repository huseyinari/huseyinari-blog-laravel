<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categoryName = $this->faker->sentence(2);
        return [
            'categoryName' => $categoryName,
            'categoryDescription' => $this->faker->paragraph(3),
            'seo' => Str::slug($categoryName)
        ];
    }
}
