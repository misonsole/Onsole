<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_divisions', function (Blueprint $table) {
            $table->increments('id');        
            $table->integer('division_id')->unsigned();        
            $table->string("description");        
            $table->timestamps();        
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('restrict');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_divisions');
    }
}
