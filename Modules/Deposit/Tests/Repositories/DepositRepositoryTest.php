<?php

namespace Modules\Deposit\Tests\Repositories;

use Modules\Deposit\Entities\Deposit;
use Modules\Deposit\Repositories\DepositRepository;
use Tests\TestCase;

class DepositRepositoryTest extends TestCase
{
    /**
     * The repository instance.
     *
     * @var DepositRepository
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
        $this->repository = $this->app->make(DepositRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName(): void
    {
        $this->assertEquals($this->repository->model(), Deposit::class);
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
