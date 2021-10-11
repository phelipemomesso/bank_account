<?php

namespace Modules\Deposit\Tests\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Modules\Account\Entities\Account;
use Modules\Account\Services\AccountService;
use Modules\Deposit\Entities\Deposit;
use Modules\Deposit\Services\DepositService;
use Tests\TestCase;

class DepositServiceTest extends TestCase
{
    /**
     * The service instance.
     *
     * @var DepositService
     */
    protected $service;

    /**
     * The service instance.
     *
     * @var AccountService
     */
    protected $accountService;

    /**
     * The entity instance.
     *
     * @var Deposit
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
        $this->service = $this->app->make(DepositService::class);
        $this->accountService = $this->app->make(AccountService::class);
    }

    /**
    * Structure of response entity.
    *
    * @return array
    */
    private function dataStructure()
    {
        return [
            'account_id', 'approved_by', 'description', 'amount', 'approved', 'image', 'created_at', 'updated_at',
        ];
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItMakeDeposit(): void
    {
        $user = User::factory()->create();
        $account = $this->accountService->hasAccount($user);
        if (!$account) {
            $account = $this->accountService->createAccount($user);
        }
        $data = [
            'description' => 'Test deposit',
            'amount' => 10,
            'check_image' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $deposit = $this->service->makeDeposit($data, $account);
        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Account::class, $account);
        $this->assertInstanceOf(Deposit::class, $deposit);
        $this->assertEquals(10, $deposit->amount);
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity(): void
    {
        $values = Deposit::factory()->make()->toArray();
        $entity = $this->service->create($values);
        $data = $entity->toArray();
        $this->assertDatabaseHas('deposit_deposits', $values);
        $this->assertInstanceOf(Deposit::class, $entity);
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
        Deposit::factory()->count(2)->create();
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
        $fake = Deposit::factory()->create();
        $entity = $this->service->find($fake->id);
        $data = $entity->toArray();
        $this->assertInstanceOf(Deposit::class, $entity);
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
        $entity = Deposit::factory()->create();
        $values = Deposit::factory()->make()->toArray();
        $entity->update($values);
        $this->assertDatabaseHas('deposit_deposits', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity(): void
    {
        $entity = Deposit::factory()->create();
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
