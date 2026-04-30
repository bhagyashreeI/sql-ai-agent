<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('query_histories', function (Blueprint $table) {
            $table->id();
            $table->text('input_text');
            $table->longText('sql_output')->nullable();
            $table->longText('builder_output')->nullable();
            $table->longText('eloquent_output')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('query_histories');
    }
};
