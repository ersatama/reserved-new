<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\CityContract;

class CreateCitiesTable extends Migration
{

    public function up()
    {
        Schema::create(CityContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::COUNTRY_ID)->nullable();
            $table->string(MainContract::TIMEZONE)->nullable();
            $table->string(MainContract::TITLE);
            $table->string(MainContract::TITLE_KZ)->nullable();
            $table->string(MainContract::TITLE_EN)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(CityContract::TABLE);
    }
}
