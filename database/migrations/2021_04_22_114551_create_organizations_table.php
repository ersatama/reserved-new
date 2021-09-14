<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\OrganizationContract;

class CreateOrganizationsTable extends Migration
{

    public function up()
    {
        Schema::create(OrganizationContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::USER_ID);
            $table->bigInteger(MainContract::CITY_ID);
            $table->bigInteger(MainContract::CATEGORY_ID);
            $table->string(MainContract::TITLE)->nullable();
            $table->float(MainContract::RATING)->nullable();
            $table->string(MainContract::IMAGE)->nullable();
            $table->string(MainContract::WALLPAPER)->nullable();
            $table->text(MainContract::DESCRIPTION)->nullable();
            $table->text(MainContract::DESCRIPTION_KZ)->nullable();
            $table->text(MainContract::DESCRIPTION_EN)->nullable();
            $table->text(MainContract::_2GIS)->nullable();
            $table->string(MainContract::ADDRESS)->nullable();
            $table->string(MainContract::ADDRESS_KZ)->nullable();
            $table->string(MainContract::ADDRESS_EN)->nullable();
            $table->string(MainContract::PRICE)->default(0);
            $table->string(MainContract::TIMEZONE)->nullable();
            $table->string(MainContract::EMAIL)->nullable();
            $table->string(MainContract::PHONE)->nullable();
            $table->string(MainContract::WEBSITE)->nullable();
            $table->string(MainContract::INSTAGRAM)->nullable();
            $table->string(MainContract::YOUTUBE)->nullable();
            $table->string(MainContract::FACEBOOK)->nullable();
            $table->string(MainContract::VK)->nullable();
            $table->integer(MainContract::TABLES)->nullable();
            $table->time(MainContract::START_MONDAY)->nullable()->default('00:00:00');
            $table->time(MainContract::END_MONDAY)->nullable()->default('00:00:00');
            $table->enum(MainContract::WORK_MONDAY,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->time(MainContract::START_TUESDAY)->nullable()->default('00:00:00');
            $table->time(MainContract::END_TUESDAY)->nullable()->default('00:00:00');
            $table->enum(MainContract::WORK_TUESDAY,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->time(MainContract::START_WEDNESDAY)->nullable()->default('00:00:00');
            $table->time(MainContract::END_WEDNESDAY)->nullable()->default('00:00:00');
            $table->enum(MainContract::WORK_WEDNESDAY,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->time(MainContract::START_THURSDAY)->nullable()->default('00:00:00');
            $table->time(MainContract::END_THURSDAY)->nullable()->default('00:00:00');
            $table->enum(MainContract::WORK_THURSDAY,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->time(MainContract::START_FRIDAY)->nullable()->default('00:00:00');
            $table->time(MainContract::END_FRIDAY)->nullable()->default('00:00:00');
            $table->enum(MainContract::WORK_FRIDAY,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->time(MainContract::START_SATURDAY)->nullable()->default('00:00:00');
            $table->time(MainContract::END_SATURDAY)->nullable()->default('00:00:00');
            $table->enum(MainContract::WORK_SATURDAY,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->time(MainContract::START_SUNDAY)->nullable()->default('00:00:00');
            $table->time(MainContract::END_SUNDAY)->nullable()->default('00:00:00');
            $table->enum(MainContract::WORK_SUNDAY,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::ON);
            $table->enum(MainContract::STATUS,MainContract::STATUSES)
                ->default(MainContract::ENABLED);
            $table->timestamps();
            $table->index(MainContract::CITY_ID);
            $table->index(MainContract::CATEGORY_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(OrganizationContract::TABLE);
    }
}
