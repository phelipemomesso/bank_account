<?php

namespace Modules\Purchase\Tests\Repositories;

use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Repositories\PurchaseRepository;
use Tests\TestCase;

class PurchaseRepositoryTest extends TestCase
{
    /**
     * The repository instance.
     *
     * @var PurchaseRepository
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
        $this->repository = $this->app->make(PurchaseRepository::class);
    }

    /**
     * Test it can specify model class name.
     *
     * @return void
     */
    public function testItCanSpecifyModelClassName(): void
    {
        $this->assertEquals($this->repository->model(), Purchase::class);
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
