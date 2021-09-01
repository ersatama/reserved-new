<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Domain\Contracts\IikoContract;

class CreateIikosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(IikoContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(IikoContract::ORGANIZATION_ID);
            $table->string(IikoContract::IIKO_ORGANIZATION_ID)->nullable();
            $table->bigInteger(IikoContract::IIKO_ID)->nullable();
            $table->string(IikoContract::API_KEY)->nullable();
            $table->string(IikoContract::API_ID)->nullable();
            $table->string(IikoContract::API_SECRET)->nullable();
            $table->enum(IikoContract::STATUS,IikoContract::STATUSES)
                ->default(IikoContract::ENABLED);
            $table->timestamps();
            $table->index(IikoContract::ORGANIZATION_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(IikoContract::TABLE);
    }
}
