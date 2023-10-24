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
        Schema::create('investments', function (Blueprint $table) {
            $table->string('InvestmentID')->unique()->primary();
            $table->string('InvestmentName');
            $table->string('InvestmentType');
            $table->text('InvestmentDescription')->nullable();
            $table->boolean('Available')->default(true);
            $table->decimal('InvestmentPrice', 10, 2);
            $table->integer('MinimumOrder');
            $table->integer('MaximumOrder');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
