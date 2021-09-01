<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\CardContract;

class CreateCardsTable extends Migration
{

    public function up()
    {
        Schema::create(CardContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(CardContract::USER_ID);
            $table->bigInteger(CardContract::CARD_ID);
            $table->string(CardContract::HASH)->nullable();
            $table->char(CardContract::MONTH,2)->nullable();
            $table->char(CardContract::YEAR,2)->nullable();
            $table->string(CardContract::BANK)->nullable();
            $table->char(CardContract::COUNTRY,2)->nullable();
            $table->char(CardContract::CARD_3D,1)->nullable();
            $table->enum(CardContract::STATUS,[
                CardContract::ON,
                CardContract::OFF
            ])->default(CardContract::ON);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(CardContract::TABLE);
    }
}
