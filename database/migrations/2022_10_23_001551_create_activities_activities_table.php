<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("activity_parent_id");
            $table->unsignedBigInteger("activity_id");
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('activity_parent_id')->references('id')->on('activities');
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
        Schema::dropIfExists('activities_activities');
    }
}
