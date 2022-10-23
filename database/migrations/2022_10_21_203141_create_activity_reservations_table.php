<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("activity_id")->index();
            $table->bigInteger("number_people");
            $table->decimal("total_price",20,2);
            $table->date("relationship_date");
            $table->date("activity_date");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('activity_id')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_reservations');
    }
}
