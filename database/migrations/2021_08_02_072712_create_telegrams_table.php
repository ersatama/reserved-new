<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Domain\Contracts\TelegramContract;

class CreateTelegramsTable extends Migration
{

    public function up()
    {
        Schema::create(TelegramContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(TelegramContract::USER_ID);
            $table->string(TelegramContract::API_TOKEN);
            $table->enum(TelegramContract::STATUS,[
                TelegramContract::ALL,
                TelegramContract::REVIEWS,
                TelegramContract::BOOKINGS,
                TelegramContract::OFF
            ])->default(TelegramContract::ALL);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TelegramContract::TABLE);
    }
}
