<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\LinkContract;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(LinkContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->text(LinkContract::KEY);
            $table->text(LinkContract::URL);
            $table->timestamp(LinkContract::EXPIRATION);
            $table->enum(LinkContract::STATUS,LinkContract::STATUSES)->default(LinkContract::ENABLED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(LinkContract::TABLE);
    }
}
