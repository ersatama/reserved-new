<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationTableListContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTableListsTable extends Migration
{
    public function up()
    {
        Schema::create(OrganizationTableListContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::ORGANIZATION_ID);
            $table->bigInteger(MainContract::ORGANIZATION_TABLE_ID);
            $table->string(MainContract::TITLE)->nullable();
            $table->string(MainContract::PRICE)->default(0);
            $table->integer(MainContract::LIMIT)->default(2);
            $table->enum(MainContract::STATUS,MainContract::STATUSES)->default(MainContract::ENABLED);
            $table->timestamps();
            $table->index(MainContract::ORGANIZATION_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(OrganizationTableListContract::TABLE);
    }
}
