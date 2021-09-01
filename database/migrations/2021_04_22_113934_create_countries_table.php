<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\CountryContract;

class CreateCountriesTable extends Migration
{

    public function up()
    {
        Schema::create(CountryContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(CountryContract::TITLE);
            $table->string(CountryContract::TITLE_KZ)->nullable();
            $table->string(CountryContract::TITLE_EN)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(CountryContract::TABLE);
    }
}
