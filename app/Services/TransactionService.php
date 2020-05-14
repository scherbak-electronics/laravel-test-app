<?php

namespace App\Services;

use App\User;
use App\Transaction;

class TransactionService
{
    /**
     * Creates user transaction
     * Probably better idea is to add a column to the users table for incrementing total amount
     * To ommit sum calculation of all user transactions
     */
    public function createUserTransaction(User $user, $amount, string $type = Transaction::TYPE_DEBIT)
    {
        $transaction = new Transaction;
        $transaction->user_id = $user->id;
        $transaction->type = $type;
        $transaction->amount = $amount;
        $transaction->save();
        return $transaction;
    }
}
