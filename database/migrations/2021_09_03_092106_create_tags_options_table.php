<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\TagsOptionContract;

class CreateTagsOptionsTable extends Migration
{

    public function up()
    {
        Schema::create(TagsOptionContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MainContract::TAGS_ID)->nullable();
            $table->string(MainContract::TITLE);
            $table->string(MainContract::TITLE_KZ)->nullable();
            $table->string(MainContract::TITLE_EN)->nullable();
            $table->enum(MainContract::STATUS,[
                MainContract::ON,
                MainContract::OFF
            ])->default(MainContract::OFF);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TagsOptionContract::TABLE);
    }
}
