<?php

use App\Domain\Contracts\ReviewContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{

    public function up()
    {
        Schema::create(ReviewContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(ReviewContract::BOOKING_ID)->unique();
            $table->bigInteger(ReviewContract::ORGANIZATION_ID);
            $table->bigInteger(ReviewContract::USER_ID);
            $table->float(ReviewContract::RATING)->nullable();
            $table->text(ReviewContract::COMMENT)->nullable();
            $table->enum(ReviewContract::STATUS,ReviewContract::STATUSES_REVIEWS)
                ->default(ReviewContract::CHECKING);
            $table->timestamps();
            $table->index(ReviewContract::ORGANIZATION_ID);
            $table->index(ReviewContract::USER_ID);
        });
    }

    public function down()
    {
        Schema::dropIfExists(ReviewContract::TABLE);
    }
}
