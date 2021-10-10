<?php

namespace Modules\Purchase\Tests\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Modules\Account\Entities\Account;
use Modules\Account\Services\AccountService;
use Modules\Deposit\Services\DepositService;
use Modules\Purchase\Entities\Purchase;
use Modules\Purchase\Services\PurchaseService;
use Tests\TestCase;

class PurchaseServiceTest extends TestCase
{
    /**
     * The service instance.
     *
     * @var PurchaseService
     */
    protected $service;

    /**
     * The service instance.
     *
     * @var DepositService
     */
    protected $depositService;

    /**
     * The service instance.
     *
     * @var AccountService
     */
    protected $accountService;

    /**
     * The entity instance.
     *
     * @var Purchase
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
        $this->service = $this->app->make(PurchaseService::class);
        $this->accountService = $this->app->make(AccountService::class);
        $this->depositService = $this->app->make(DepositService::class);
    }

    /**
    * Structure of response entity.
    *
    * @return array
    */
    private function dataStructure()
    {
        return [
            'account_id', 'description', 'amount', 'created_at', 'updated_at',
        ];
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItMakePurchase(): void
    {
        $user = User::factory()->create();
        $account = $this->accountService->hasAccount($user);
        if (!$account) {
            $account = $this->accountService->createAccount($user);
        }
        $dataDeposit = [
            'description' => 'Test deposit',
            'amount' => 100,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $deposit = $this->depositService->makeDeposit($dataDeposit, $account);
        $updateBalance = $this->accountService->updateBalance($account, $dataDeposit['amount'], 'C');
        $dataPurchase = [
            'description' => 'Test Purchase',
            'amount' => 90,
        ];
        $purchase = null;
        $updateBalancePurchase = null;
         if ($this->service->verifyBalance($updateBalance, $dataPurchase['amount'])) {
             $purchase = $this->service->makePurchase($dataPurchase, $updateBalance);
             $updateBalancePurchase = $this->accountService->updateBalance($updateBalance, $dataPurchase['amount'], 'D');
         }

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Account::class, $account);
        $this->assertInstanceOf(Purchase::class, $purchase);
        $this->assertEquals(100, $deposit->amount,'Deposit value $100');
        $this->assertEquals(100, $updateBalance->balance,'Balance equal $100');
        $this->assertEquals(90, $purchase->amount, 'Purchase value $90');
        $this->assertEquals(10, $updateBalancePurchase->balance,'Balance equal $10');
    }

     /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItMakePurchaseWithoutBalance(): void
    {
        $user = User::factory()->create();
        $account = $this->accountService->hasAccount($user);
        if (!$account) {
            $account = $this->accountService->createAccount($user);
        }

        $dataDeposit = [
            'description' => 'Test deposit',
            'amount' => 100,
            'image' => UploadedFile::fake()->image('avatar.jpg')
        ];
        $deposit = $this->depositService->makeDeposit($dataDeposit, $account);
        $updateBalance = $this->accountService->updateBalance($account, $dataDeposit['amount'], 'C');

        $dataPurchase = [
            'description' => 'Test Purchase',
            'amount' => 90,
        ];
        $purchase = null;
         if ($this->service->verifyBalance($account, $dataPurchase['amount'])) {
             $purchase = $this->service->makePurchase($dataPurchase, $account);
             $updateBalancePurchase = $this->accountService->updateBalance($account, $dataPurchase['amount'], 'D');
         }

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals(100, $deposit->amount,'Deposit value $100');
        $this->assertEquals(100, $updateBalance->balance,'Balance equal $100');
        $this->assertEquals(null, $purchase, 'Does not have enough balance');
    }

    /**
     * Test it can store a newly created entity in storage.
     *
     * @return void
     */
    public function testItCanCreateEntity(): void
    {
        $values = Purchase::factory()->make()->toArray();
        $entity = $this->service->create($values);
        $data = $entity->toArray();
        $this->assertDatabaseHas('purchase_purchases', $values);
        $this->assertInstanceOf(Purchase::class, $entity);
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
        Purchase::factory()->count(2)->create();
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
        $fake = Purchase::factory()->create();
        $entity = $this->service->find($fake->id);
        $data = $entity->toArray();
        $this->assertInstanceOf(Purchase::class, $entity);
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
        $entity = Purchase::factory()->create();
        $values = Purchase::factory()->make()->toArray();
        $entity->update($values);
        $this->assertDatabaseHas('purchase_purchases', $values);
    }

    /**
     * Test it can remove the specified entity from storage.
     *
     * @return void
     */
    public function testItCanDestroyEntity(): void
    {
        $entity = Purchase::factory()->create();
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
