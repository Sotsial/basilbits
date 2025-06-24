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
            $table->string('slug')->unique();
            $table->string('price')->nullable();
            $table->boolean('on_request')->default(false);
            $table->string('title_image');
            $table->text('screenshots')->nullable();
            $table->enum('platform', ['ios', 'android']);
            $table->string('earnings');
            $table->string('age');
            $table->string('installs');
            $table->text('monetization')->nullable();
            $table->text('attachments')->nullable();
            $table->text('financials')->nullable();
            $table->text('description');
            $table->string('link')->nullable();
            $table->text('payment_methods')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('video_link')->nullable();
            $table->text('specials')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('seller_id')->references('id')->on('users');
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
