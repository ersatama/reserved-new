<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\NewsContract;

class CreateNewsTable extends Migration
{

    public function up()
    {
        Schema::create(NewsContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::ORGANIZATION_ID)->nullable();
            $table->string(MainContract::TITLE)->nullable();
            $table->text(MainContract::DESCRIPTION)->nullable();
            $table->enum(MainContract::STATUS,[
                MainContract::ON,
                MainContract::CHECKING,
                MainContract::OFF
            ])->default(MainContract::CHECKING);
            $table->timestamps();
            $table->index(MainContract::ORGANIZATION_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(NewsContract::TABLE);
    }

}
