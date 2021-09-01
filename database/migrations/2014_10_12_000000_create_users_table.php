<?php

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
            $table->unsignedBigInteger(UserContract::USER_ID)->nullable();
            $table->enum(UserContract::ROLE,UserContract::ROLES)
                ->default(UserContract::USER);
            $table->enum(UserContract::BLOCKED,UserContract::STATE)->default(UserContract::ON);
            $table->string(UserContract::NAME);
            $table->string(UserContract::AVATAR)
                ->nullable();
            $table->string(UserContract::PHONE)
                ->nullable()
                ->unique();
            $table->char(UserContract::CODE,6)
                ->nullable();
            $table->timestamp(UserContract::PHONE_VERIFIED_AT)
                ->nullable();
            $table->string(UserContract::EMAIL)
                ->nullable()
                ->unique();
            $table->timestamp(UserContract::EMAIL_VERIFIED_AT)
                ->nullable();
            $table->string(UserContract::PASSWORD);
            $table->string(UserContract::API_TOKEN)->unique()
                ->nullable()
                ->default(null);
            $table->bigInteger(UserContract::LANGUAGE_ID)->nullable();
            $table->enum(UserContract::EMAIL_NOTIFICATION,[
                UserContract::ON,
                UserContract::OFF,
            ])->default(UserContract::ON);
            $table->enum(UserContract::PUSH_NOTIFICATION,[
                UserContract::ON,
                UserContract::OFF,
            ])->default(UserContract::ON);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->index(UserContract::USER_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(UserContract::TABLE);
    }
}
