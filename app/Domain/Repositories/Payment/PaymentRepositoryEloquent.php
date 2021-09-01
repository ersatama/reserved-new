<?php


namespace App\Domain\Repositories\Payment;

use App\Domain\Contracts\PaymentContract;
use App\Models\Payment;

class PaymentRepositoryEloquent implements PaymentRepositoryInterface
{
    public function create($data) {
        return Payment::create($data);
    }

    public function success($id) {
        Payment::where(PaymentContract::BOOKING_ID,$id)->update([
            PaymentContract::STATUS =>  PaymentContract::PAYED
        ]);
    }

    public function failure($id) {
        Payment::where(PaymentContract::BOOKING_ID,$id)->update([
            PaymentContract::STATUS =>  PaymentContract::DISABLED
        ]);
    }
}
