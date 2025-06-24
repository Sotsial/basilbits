<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('price')->nullable();
            $table->string('title_image');
            $table->text('screenshots')->nullable(); // JSON
            $table->string('platform');
            $table->string('earnings');
            $table->string('age');
            $table->string('installs');
            $table->text('monetization'); // JSON
            $table->text('attachments')->nullable(); // JSON
            $table->text('financials')->nullable(); // JSON
            $table->text('description');
            $table->string('link')->nullable();
            $table->text('payment_methods')->nullable(); // JSON
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('video_link')->nullable();
            $table->text('specials')->nullable(); // JSON
            $table->unsignedBigInteger('added_by');
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('users');
            $table->foreign('seller_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
