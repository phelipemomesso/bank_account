<?php
namespace Modules\Deposit\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Account\Entities\Account;

class DepositFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Deposit\Entities\Deposit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $approved = $this->faker->numberBetween(0, 1);
        $approvedBy = $approved == 0 ? null :  User::factory()->create();
        return [
            'account_id' => Account::factory()->create(),
            'approved_by' => $approvedBy,
            'description' => $this->faker->words(3, true),
            'amount' => $this->faker->randomFloat(2),
            'approved' => $approved,
            'image' => $this->faker-> numerify('check-value-####').'.jpg'
        ];
    }
}
