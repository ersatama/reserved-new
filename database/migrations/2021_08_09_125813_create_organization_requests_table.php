<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\OrganizationRequestContract;

class CreateOrganizationRequestsTable extends Migration
{

    public function up()
    {
        Schema::create(OrganizationRequestContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(MainContract::NAME);
            $table->string(MainContract::PHONE);
            $table->string(MainContract::ORGANIZATION_NAME);
            $table->integer(MainContract::CATEGORY_ID);
            $table->integer(MainContract::CITY_ID);
            $table->enum(MainContract::STATUS,[
                MainContract::ON,
                MainContract::OFF,
                MainContract::REJECTED
            ])->default(MainContract::ON);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(OrganizationRequestContract::TABLE);
    }
}
