<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("item_types", function(Blueprint $table){
            $table->id();
            $table->string('name');
        });
        Schema::create("items", function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->foreignId('item_type_id')->constrained("item_types");
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
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_types');
    }
};
