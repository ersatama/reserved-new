<?php

use App\Domain\Contracts\CategoryContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create(CategoryContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(CategoryContract::SLUG);
            $table->string(CategoryContract::TITLE);
            $table->string(CategoryContract::TITLE_KZ)->nullable();
            $table->string(CategoryContract::TITLE_EN)->nullable();
            $table->text(CategoryContract::DESCRIPTION)->nullable();
            $table->text(CategoryContract::DESCRIPTION_KZ)->nullable();
            $table->text(CategoryContract::DESCRIPTION_EN)->nullable();
            $table->string(CategoryContract::IMAGE)->nullable();
            $table->string(CategoryContract::WALLPAPER)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(CategoryContract::TABLE);
    }
}
