<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\WebTrafficContract;

class CreateWebTrafficTable extends Migration
{

    public function up()
    {
        Schema::create(WebTrafficContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::ORGANIZATION_ID)->nullable();
            $table->string(MainContract::WEBSITE)->nullable();
            $table->string(MainContract::IP)->nullable();
            $table->enum(MainContract::STATUS,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(WebTrafficContract::TABLE);
    }
}
