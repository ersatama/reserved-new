<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Domain\Contracts\TelegramChatContract;

class CreateTelegramChatsTable extends Migration
{

    public function up()
    {
        Schema::create(TelegramChatContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(TelegramChatContract::TELEGRAM_ID);
            $table->bigInteger(TelegramChatContract::TELEGRAM_CHAT_ID);
            $table->enum(TelegramChatContract::STATUS,[
                TelegramChatContract::ON,
                TelegramChatContract::OFF
            ])->default(TelegramChatContract::ON);
            $table->timestamps();
            $table->index(TelegramChatContract::TELEGRAM_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(TelegramChatContract::TABLE);
    }
}
