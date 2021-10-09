<?php

namespace Modules\Account\Tests\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Modules\Account\Entities\Account;
use Modules\Account\Services\AccountService;
use Tests\TestCase;

class AccountServiceTest extends TestCase
{
    /**
     * The service instance.
     *
     * @var AccountService
     */
    protected $service;

    /**
     * The entity instance.
     *
     * @var Account
     */
    protected $type;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        $this->service = $this->app->make(AccountService::class);
    }

    /**
    * Structure of response entity.
    *
    * @return array
    */
    private function dataStructure()
    {
        return [
            'user_id', 'balance', 'created_at', 'updated_at',
        ];
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity(): void
    {
        $values = Account::factory()->make()->toArray();
        $entity = $this->service->create($values);
        $data = $entity->toArray();
        $this->assertDatabaseHas('account_accounts', $values);
        $this->assertInstanceOf(Account::class, $entity);
        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can display a listing of the entity.
     *
     * @return void
     */
    public function testItCanListingEntity(): void
    {
        $amount = 2;
        Account::factory()->count(2)->create();
        $list = $this->service->paginate();
        $data = current($list->items())->toArray();
        $this->assertInstanceOf(LengthAwarePaginator::class, $list);
        $this->assertEquals($amount, $list->total());
        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can show the specified entity.
     *
     * @return void
     */
    public function testItCanShowEntity(): void
    {
        $fake = Account::factory()->create();
        $entity = $this->service->find($fake->id);
        $data = $entity->toArray();
        $this->assertInstanceOf(Account::class, $entity);
        foreach ($this->dataStructure() as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Test it can update the specified entity in storage.
     *
     * @return void
     */
    public function testItCanUpdateEntity(): void
    {
        $entity = Account::factory()->create();
        $values = Account::factory()->make()->toArray();
        $entity->update($values);
        $this->assertDatabaseHas('account_accounts', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity(): void
    {
        $entity = Account::factory()->create();
        $response = $this->service->delete($entity->id);
        $this->assertTrue($response);
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
