<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Domain\Contracts\LanguagesContract;

class CreateLanguagesTable extends Migration
{

    public function up()
    {
        Schema::create(LanguagesContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(LanguagesContract::TITLE)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(LanguagesContract::TABLE);
    }
}
