<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeirarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heirarchies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('heirarchy_id')->unique();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('status')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('heirarchies');
    }
}
