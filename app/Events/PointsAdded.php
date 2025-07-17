<?php

namespace App\Events;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PointsAdded
{
    use Dispatchable, SerializesModels;

    public $customer;
    public $transaction;

    public function __construct(Customer $customer, Transaction $transaction)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
    }
}
