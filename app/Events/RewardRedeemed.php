<?php

namespace App\Events;

use App\Models\Customer;
use App\Models\Redemption;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RewardRedeemed
{
    use Dispatchable, SerializesModels;

    public $customer;
    public $redemption;

    public function __construct(Customer $customer, Redemption $redemption)
    {
        $this->customer = $customer;
        $this->redemption = $redemption;
    }
}
