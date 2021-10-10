<?php

namespace Modules\Deposit\Tests\Entities;

use App\Models\User;
use Database\Factories\UserFactory;
use Modules\Deposit\Entities\Deposit;
use Tests\TestCase;

class DepositTest extends TestCase
{
    /**
     * The entity instance.
     *
     * @var Type
     */
    protected $model;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->model = $this->app->make(Deposit::class);
    }

    /**
     * Test it can specify table name.
     *
     * @return void
     */
    public function testItCanSpecifyTableName(): void
    {
        $this->assertEquals($this->model->getTable(), 'deposit_deposits');
    }

    /**
     * Test it can specify fillable fields.
     *
     * @return void
     */
    public function testItCanSpecifyFillableFields(): void
    {
        $fillable = ['account_id', 'approved_by', 'amount', 'approved', 'image'];
        $this->assertTrue($fillable == $this->model->getFillable());
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }
}
