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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('default.png');

            $table->string('code');
            $table->string('title');
            $table->text('description');
            $table->string('activate_url');

            $table->integer('views_count')->default(0);
            $table->integer('usages_count')->default(0);

            $table->integer('user_id');
            $table->integer('moderator_id')->nullable();
            $table->enum('moderate_status', ['new', 'in_work', 'rejected', 'accepted'])->default('new');
            $table->string('moderate_message')->nullable();
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
        Schema::dropIfExists('codes');
    }
};
