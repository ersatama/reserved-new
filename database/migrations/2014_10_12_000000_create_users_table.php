<?php

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Contracts\UserContract;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create(UserContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::USER_ID)->nullable();
            $table->enum(MainContract::ROLE,MainContract::ROLES)
                ->default(MainContract::USER);
            $table->enum(MainContract::BLOCKED,MainContract::STATE)->default(MainContract::ON);
            $table->string(MainContract::NAME);
            $table->string(MainContract::AVATAR)
                ->nullable();
            $table->string(MainContract::PHONE)
                ->nullable()
                ->unique();
            $table->char(MainContract::CODE,6)
                ->nullable();
            $table->timestamp(MainContract::PHONE_VERIFIED_AT)
                ->nullable();
            $table->string(MainContract::EMAIL)
                ->nullable()
                ->unique();
            $table->timestamp(MainContract::EMAIL_VERIFIED_AT)
                ->nullable();
            $table->string(MainContract::PASSWORD);
            $table->string(MainContract::API_TOKEN)->unique()
                ->nullable()
                ->default(null);
            $table->bigInteger(MainContract::LANGUAGE_ID)->nullable();
            $table->enum(MainContract::EMAIL_NOTIFICATION,[
                MainContract::ON,
                MainContract::OFF,
            ])->default(MainContract::ON);
            $table->enum(MainContract::PUSH_NOTIFICATION,[
                MainContract::ON,
                MainContract::OFF,
            ])->default(MainContract::ON);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->index(MainContract::USER_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(UserContract::TABLE);
    }
}
