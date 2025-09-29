<?php

namespace App\Models\Gamification;

enum TransactionDirection: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';
}
