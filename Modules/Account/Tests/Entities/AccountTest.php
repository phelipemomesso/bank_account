<?php

namespace Modules\Account\Tests\Entities;

use App\Models\User;
use Database\Factories\UserFactory;
use Modules\Account\Entities\Account;
use Tests\TestCase;

class AccountTest extends TestCase
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

        $this->model = $this->app->make(Account::class);
    }

    /**
     * Test it can specify table name.
     *
     * @return void
     */
    public function testItCanSpecifyTableName(): void
    {
        $this->assertEquals($this->model->getTable(), 'account_accounts');
    }

    /**
     * Test it can specify fillable fields.
     *
     * @return void
     */
    public function testItCanSpecifyFillableFields(): void
    {
        $fillable = [
            'user_id',
            'balance'
        ];

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
