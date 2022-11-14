<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function findCustomer($line_id)
    {
        return Customer::withTrashed()->where('line_id', $line_id)->first();
    }

    public function deleteCustomer($line_id)
    {
        DB::transaction(function () use ($line_id) {
            $customer = $this->findCustomer($line_id);
            if (!is_null($customer)) {
                session()->forget($customer->line_id);
                $customer->delete();
            }
        });
    }

    public function setIsFollowed($line_id)
    {
        DB::transaction(function () use ($line_id) {
            Customer::create([
                'line_id' => $line_id,
                'is_followed' => 1
            ]);
        });
    }

    public function updateNickname($event, $customer)
    {
        DB::transaction(function () use ($event, $customer) {
            $customer->fill([
                'nickname' => $event->getText(),
                'is_confirm_send' => 1
            ])->save();
        });
    }

    public function deleteNickname($customer)
    {
        DB::transaction(function () use ($customer) {
            $customer->fill([
                'nickname' => null,
                'is_confirm_send' => null
            ])->save();
        });
    }
}

?>
