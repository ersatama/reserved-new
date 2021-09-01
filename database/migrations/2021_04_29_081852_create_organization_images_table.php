<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\OrganizationImageContract;

class CreateOrganizationImagesTable extends Migration
{

    public function up()
    {
        Schema::create(OrganizationImageContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::ORGANIZATION_ID);
            $table->string(MainContract::IMAGE)->nullable();
            $table->enum(MainContract::STATUS,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->timestamps();
            $table->index(MainContract::ORGANIZATION_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(OrganizationImageContract::TABLE);
    }
}
