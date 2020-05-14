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

class BusinessLogicTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Check if endpoint actually retrieves the last 10 created users 
     * along with the sum of all their debit transactions.
     * comparing each user total with user total from other select query
     *
     * @return void
     */
    public function testUserTransactionsTotal()
    {
        $userRepo = new UserRepository;
        $allUsers = $userRepo->getAllUsers();
        $usersWithTotals = $userRepo->getLastCreatedUsersWithSumOfDebitTransactions();
        foreach($allUsers as $user) {
            foreach($usersWithTotals as $userWithTotal) {
                if ($user->id == $userWithTotal->id) {
                    $oneUserWithTotal = $userRepo->getUserWithSumOfDebitTransactions($user->id);
                    $this->assertEquals($userWithTotal->total, $oneUserWithTotal->first()->total);
                }
            }
        }
    }
}

