<?php
namespace Modules\Purchase\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Account\Entities\Account;

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Purchase\Entities\Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       return [
            'account_id' => Account::factory()->create(),
            'description' => $this->faker->words(3, true),
            'amount' => $this->faker->randomFloat(2),
        ];
    }
}

