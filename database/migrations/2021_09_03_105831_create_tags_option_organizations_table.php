<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\TagsOptionOrganizationContract;

class CreateTagsOptionOrganizationsTable extends Migration
{

    public function up()
    {
        Schema::create(TagsOptionOrganizationContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::TAGS_OPTION_ID);
            $table->bigInteger(MainContract::ORGANIZATION_ID);
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
        Schema::dropIfExists(TagsOptionOrganizationContract::TABLE);
    }
}
