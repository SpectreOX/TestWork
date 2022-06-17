<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'author_name' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'isbn' => $this->faker->regexify('[A-Za-z0-9]{6}'),
            'publish_date' => $this->faker->year(),
            'category_id' => 1,
        ];
    }
}
