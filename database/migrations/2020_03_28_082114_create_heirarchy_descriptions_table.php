<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeirarchyDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heirarchy_descriptions', function (Blueprint $table) {
            $table->bigIncrements('id');

            //information of which heirarchy
            $table->string('heirarchy_id')->unique();
            $table->foreign('heirarchy_id')->references('heirarchy_id')->on('heirarchies');
            
            //true if the heirarchy is root
            $table->boolean('is_root')->default(false);

            //child of which parent
            $table->string('parent_id')->nullable();
            $table->foreign('parent_id')->references('heirarchy_id')->on('heirarchies');

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
        Schema::dropIfExists('heirarchy_descriptions');
    }
}
