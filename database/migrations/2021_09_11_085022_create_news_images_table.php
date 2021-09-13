<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\NewsImageContract;

class CreateNewsImagesTable extends Migration
{

    public function up()
    {
        Schema::create(NewsImageContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::NEWS_ID)->nullable();
            $table->string(MainContract::IMAGE);
            $table->enum(MainContract::STATUS,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->timestamps();
            $table->index(MainContract::NEWS_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(NewsImageContract::TABLE);
    }
}
