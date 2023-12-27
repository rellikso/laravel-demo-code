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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('url', 2048);
            $table->string('title');
            $table->string('preview', 2048);
            $table->text('description');
            $table->float('price');

            $table
                ->float('previous_price')
                ->nullable();

            $table->string('currency_code');
            $table->string('currency_symbol');
            $table->timestamps();
        });

        Schema::create('subscriber_adverts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscriber_id');
            $table->unsignedBigInteger('advert_id');
            $table->timestamps();
        });

        Schema::table('subscriber_adverts', function (Blueprint $table) {
            $table->index(['subscriber_id', 'advert_id'], 'subscriber_advert');

            $table->foreign('subscriber_id')
                ->references('id')
                ->on('subscribers')
                ->cascadeOnDelete();

            $table->foreign('advert_id')
                ->references('id')
                ->on('adverts')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriber_adverts');
        Schema::dropIfExists('adverts');
        Schema::dropIfExists('subscribers');
    }
};
