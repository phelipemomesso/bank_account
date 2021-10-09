<?php

namespace Modules\Account\Tests\Repositories;

use Modules\Account\Entities\Account;
use Modules\Account\Repositories\AccountRepository;
use Tests\TestCase;

class AccountRepositoryTest extends TestCase
{
    /**
     * The repository instance.
     *
     * @var AccountRepository
     */
    protected $repository;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(AccountRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName(): void
    {
        $this->assertEquals($this->repository->model(), Account::class);
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
