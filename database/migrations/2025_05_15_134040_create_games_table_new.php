<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTableNew extends Migration
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
            $table->string('slug')->unique()->nullable(); // Поле для красивых URL
            $table->string('price')->nullable();
            $table->boolean('on_request')->default(false);
            $table->string('title_image');
            $table->text('screenshots')->nullable(); // JSON
            $table->string('platform');
            $table->string('earnings');
            $table->string('age');
            $table->string('installs');
            $table->text('monetization')->nullable(); // JSON
            $table->text('attachments')->nullable(); // JSON
            $table->text('financials')->nullable(); // JSON
            $table->text('description');
            $table->string('link')->nullable();
            $table->text('payment_methods')->nullable(); // JSON
            $table->foreignId('seller_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('video_link')->nullable();
            $table->text('specials')->nullable(); // JSON
            $table->foreignId('user_id')->constrained('users'); // Связь с пользователем, который добавил игру
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
        Schema::dropIfExists('games');
    }
}