<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('facebook_user_id');
            $table->string('page_id');
            $table->text('page_cover')->nullable();
            $table->text('page_profile')->nullable();
            $table->string('page_name');
            $table->string('username')->nullable();
            $table->text('page_access_token');
            $table->string('page_email')->nullable();
            $table->boolean('msg_manager')->default(false);
            $table->enum('bot_enabled', ['0', '1', '2'])->default('0');
            $table->boolean('started_button_enabled')->default(false);
            $table->string('welcome_message')->default(false);
            $table->boolean('persistent_enabled')->default(false);
            $table->boolean('enable_mark_seen')->default(false);
            $table->boolean('enbale_type_on')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facebook_pages');
    }
}
