<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // type
    const TYPE_DEBIT = 'debit';
    const TYPE_CREDIT = 'credit';
}
