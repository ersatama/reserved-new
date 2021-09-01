<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\OrganizationTablesContract;

class CreateOrganizationTablesTable extends Migration
{

    public function up()
    {
        Schema::create(OrganizationTablesContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(OrganizationTablesContract::ORGANIZATION_ID);
            $table->string(OrganizationTablesContract::NAME)->nullable();
            $table->enum(OrganizationTablesContract::STATUS,OrganizationTablesContract::STATUSES)->default(OrganizationTablesContract::ENABLED);
            $table->timestamps();
            $table->index(OrganizationTablesContract::ORGANIZATION_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(OrganizationTablesContract::TABLE);
    }
}
