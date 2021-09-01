<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\PaymentContract;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create(PaymentContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(PaymentContract::BOOKING_ID);
            $table->string(PaymentContract::PRICE);
            $table->unsignedBigInteger(PaymentContract::PG_PAYMENT_ID)->nullable()->unqiue();
            $table->string(PaymentContract::PG_REDIRECT_URL)->nullable();
            $table->string(PaymentContract::PG_SIG)->nullable();
            $table->enum(PaymentContract::STATUS,PaymentContract::PAYMENT_STATUSES)->default(PaymentContract::ENABLED);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(PaymentContract::TABLE);
    }
}
