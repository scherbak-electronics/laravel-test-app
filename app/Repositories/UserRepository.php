<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getById($id)
    {
        return User::where('id', $id)->first();
    }

    public function getAdminUser()
    {
        return User::where('admin', true)->first();
    }
    
    /** 
     * retrieves the last 10 created users along with 
     * the sum of all their debit transactions.
     */
    public function getLastCreatedUsersWithSumOfDebitTransactions($numberOfLast = 10)
    {
        return User::select('users.*', DB::raw('SUM(transactions.amount) AS total')) //DB::raw('sum(transacions.amount) as transactions_total')
            ->join('transactions', 'users.id', '=', 'transactions.user_id')
            ->groupBy('users.id')
            ->latest('users.created_at')
            ->limit($numberOfLast)
            ->get();
    }

    /** 
     * retrieves one user by id along with 
     * the sum of all his debit transactions.
     */
    public function getUserWithSumOfDebitTransactions($id)
    {
        return User::select('users.*', DB::raw('SUM(transactions.amount) AS total'))
            ->join('transactions', 'users.id', '=', 'transactions.user_id')
            ->groupBy('users.id')
            ->where('users.id', $id)
            ->get();
    }
}
