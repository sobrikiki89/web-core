<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter', function (Blueprint $table) {
            $table->string('code')->nullable(false);
            $table->primary('code');
            $table->string('name');
            $table->integer('sortOrder');
            $table->string('description')->nullable();
            $table->boolean('status');
            $table->string('category_parameter_code')->nullable(false);
            $table->foreign('category_parameter_code')->references('code')->on('category_parameter')->onDelete('cascade');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('created_date');
            $table->dateTime('updated_date');
            
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter');
    }
}
