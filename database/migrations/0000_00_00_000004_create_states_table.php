<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('finalized');
            $table->string('class')->unique();
            $table->string('type');
            $table->string('icon')->nullable();
            $table->timestamps();
            $table->unique(["class", "type"], 'class_type_unique');
            $table->unique(["name", "type"], 'name_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
}
