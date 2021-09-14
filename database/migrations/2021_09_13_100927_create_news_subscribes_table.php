<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\NewsSubscribeContract;

class CreateNewsSubscribesTable extends Migration
{

    public function up()
    {
        Schema::create(NewsSubscribeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::USER_ID);
            $table->bigInteger(MainContract::ORGANIZATION_ID);
            $table->enum(MainContract::STATUS,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(NewsSubscribeContract::TABLE);
    }
}
