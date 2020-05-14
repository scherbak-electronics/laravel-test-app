<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Repositories\UserRepository;
use App\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Creates transaction for admin user
     * and checks if transaction with admin user id exist in database
     *
     * @return void
     */
    public function testCreateUserTransaction()
    {
        $users = new UserRepository;
        $transactionService = new TransactionService;
        $adminUser = $users->getAdminUser();
        $transactionService->createUserTransaction($adminUser, 15.99);
        $this->assertDatabaseHas('transactions', ['user_id' => $adminUser->id]);
    }

    /**
     * Creates transaction for admin user
     * then selects all user transactions 
     * and validate that any transactions actually selected 
     *
     * @return void
     */
    public function testAdminUserCreateAndGetTransactions()
    {
        $transactionRepo = new TransactionRepository;
        $users = new UserRepository;
        $transactionService = new TransactionService;
        $adminUser = $users->getAdminUser();
        $amount = 15.99;
        $transactionService->createUserTransaction($adminUser, $amount);
        $transactions = $transactionRepo->getByUserId($adminUser->id);
        $this->assertGreaterThan(0, $transactions->count());
    }
}

