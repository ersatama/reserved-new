<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\BookingContract;

class CreateBookingsTable extends Migration
{

    public function up()
    {
        Schema::create(BookingContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(MainContract::IIKO_BOOKING_ID)->nullable();

            $table->bigInteger(MainContract::USER_ID)->nullable();
            $table->bigInteger(MainContract::ORGANIZATION_ID)->nullable();
            $table->bigInteger( MainContract::ORGANIZATION_TABLE_LIST_ID)->nullable();
            $table->time(MainContract::TIME)->useCurrent();
            $table->date(MainContract::DATE)->useCurrent();
            $table->enum(MainContract::STATUS,MainContract::STATUSES_BOOKING)
                ->default(MainContract::CHECKING);
            $table->enum(MainContract::COMMENT,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->string(MainContract::PAYMENT_URL)->nullable();
            $table->bigInteger(MainContract::PAYMENT_ID)->nullable();
            $table->string(MainContract::PRICE)->nullable();
            $table->smallInteger(MainContract::CURRENCY)->default(1);
            $table->bigInteger(MainContract::CARD_ID)->nullable();

            $table->timestamps();

            $table->index(MainContract::USER_ID);
            $table->index(MainContract::ORGANIZATION_ID);
            $table->index(MainContract::ORGANIZATION_TABLE_LIST_ID);
            $table->index(MainContract::CARD_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(BookingContract::TABLE);
    }
}
