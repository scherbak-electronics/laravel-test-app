<?php

namespace App\Repositories;

use App\Transaction;

class TransactionRepository
{
    public function getAllTransactions()
    {
        return Transaction::all();
    }

    public function getByUserId($userId)
    {
        return Transaction::where('user_id', $userId)->get();
    }
}
