<?php

namespace Database\Factories;

use App\Models\Rentals;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentalsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rentals::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => random_int(1, 10),
            'item_id' => random_int(1, 10),
            'status_id' => random_int(1, 2),
        ];
    }
}
