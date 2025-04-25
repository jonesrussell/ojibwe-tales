<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('path');
            $table->bigInteger('size');
            $table->integer('duration')->nullable();
            $table->string('status')->default('uploaded');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}; 