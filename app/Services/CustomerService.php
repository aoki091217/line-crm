<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function findCustomer($line_token)
    {
        return Customer::withTrashed()->where('line_token', $line_token)->first();
    }

    public function deleteCustomer($line_token)
    {
        DB::transaction(function () use ($line_token) {
            $customer = $this->findCustomer($line_token);
            if (!is_null($customer)) {
                session()->forget($customer->line_token);
                $customer->delete();
            }
        });
    }

    public function setIsFollowed($line_token)
    {
        DB::transaction(function () use ($line_token) {
            Customer::create([
                'line_token' => $line_token,
                'is_followed' => 1
            ]);
        });
    }

    public function updateNickname($event, $customer)
    {
        DB::transaction(function () use ($event, $customer) {
            $customer->fill([
                'name' => $event->getText(),
                'is_confirm_send' => 1
            ])->save();
        });
    }

    public function deleteNickname($customer)
    {
        DB::transaction(function () use ($customer) {
            $customer->fill([
                'name' => null,
                'is_confirm_send' => null
            ])->save();
        });
    }
}

?>
