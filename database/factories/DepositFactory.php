<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Deposit;

class DepositFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var  string
     */
    protected $model = Deposit::class;

    /**
     * Define the model's default state.
     *
     * @return  array
     */
    public function definition(): array
    {
        return [
            'payment_method' => $this->faker->numberBetween(1, 3),
            'amount' => $this->faker->randomFloat(),
            'transaction_number' => $this->faker->word,
            'status' => $this->faker->randomElement([1, 2, 3]),
            'is_on_booking' => $this->faker->randomElement([0, 1]),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
