<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookCtaPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_cta_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('facebook_user_id');
            $table->text('message');
            $table->text('carousel_content')->nullable();
            $table->text('carousel_link')->nullable();
            $table->string('page_group_user_id');
            $table->enum('page_or_group_or_user', ['page', 'group', 'user']);
            $table->string('page_or_group_or_user_name')->nullable();
            $table->enum('posting_status', ['0', '1', '2'])->default('0');
            $table->string('post_id')->nullable();
            $table->text('post_url')->nullable();
            $table->dateTime('last_updated_at')->nullable();
            $table->dateTime('schedule_time');
            $table->string('time_zone');
            $table->string('post_type')->nullable();
            $table->text('error_mesage')->nullable();
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
        Schema::dropIfExists('facebook_cta_posts');
    }
}
