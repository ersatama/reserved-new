<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Domain\Contracts\IikoTablesContract;

class CreateIikoTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(IikoTablesContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(IikoTablesContract::IIKO_MAIN_ID);
            $table->string(IikoTablesContract::KEY)->nullable();
            $table->string(IikoTablesContract::NAME)->nullable();
            $table->enum(IikoTablesContract::STATUS,IikoTablesContract::STATUSES)->default(IikoTablesContract::ENABLED);
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
        Schema::dropIfExists(IikoTablesContract::TABLE);
    }
}
