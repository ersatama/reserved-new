<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\TagsContract;

class CreateTagsTable extends Migration
{

    public function up()
    {
        Schema::create(TagsContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(MainContract::TITLE);
            $table->string(MainContract::TITLE_KZ)->nullable();
            $table->string(MainContract::TITLE_EN)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(TagsContract::TABLE);
    }
}
