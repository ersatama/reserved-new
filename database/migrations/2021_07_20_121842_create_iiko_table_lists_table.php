<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Domain\Contracts\IikoTableListContract;

class CreateIikoTableListsTable extends Migration
{

    public function up()
    {
        Schema::create(IikoTableListContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(IikoTableListContract::IIKO_MAIN_ID);
            $table->bigInteger(IikoTableListContract::IIKO_TABLE_ID);
            $table->bigInteger(IikoTableListContract::ORGANIZATION_TABLE_LIST_ID)->nullable();
            $table->string(IikoTableListContract::KEY);
            $table->string(IikoTableListContract::TITLE);
            $table->string(IikoTableListContract::LIMIT)->default(1);
            $table->enum(IikoTableListContract::STATUS,IikoTableListContract::STATUSES)->default(IikoTableListContract::ENABLED);
            $table->timestamps();
            $table->index(IikoTableListContract::IIKO_MAIN_ID);
            $table->index(IikoTableListContract::ORGANIZATION_TABLE_LIST_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(IikoTableListContract::TABLE);
    }
}
