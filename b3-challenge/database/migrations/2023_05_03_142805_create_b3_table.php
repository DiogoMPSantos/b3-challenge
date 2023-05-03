<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('b3', function (Blueprint $table) {
            $table->id();
            $table->date('rpttd');
            $table->string('tckrsymb');
            $table->string('isin');
            $table->string('asst');
            $table->integer('balqty');
            $table->float('tradavrgpric');
            $table->integer('pricfctr');
            $table->float('balval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b3');
    }
};
