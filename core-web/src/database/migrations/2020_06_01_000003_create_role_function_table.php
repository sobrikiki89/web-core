<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_function', function (Blueprint $table) {
            $table->string('function_code');
            $table->foreign('function_code')->references('code')->on('app_function')->onDelete('cascade');
            $table->bigInteger('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade');
            $table->unique(['function_code', 'role_id']);
            $table->boolean('createable')->nullable();
            $table->boolean('deleteable')->nullable();
            $table->boolean('readable')->nullable();
            $table->boolean('updateable')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_function');
    }
}
