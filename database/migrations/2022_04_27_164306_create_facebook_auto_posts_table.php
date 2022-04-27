<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookAutoPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_auto_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('facebook_user_id');
            $table->string('campaign_name');
            $table->enum('post_type', ['text_submit', 'link_submit', 'image_submit', 'video_submit'])->default('text_submit');
            $table->string('page_group_user_id')->nullable();
            $table->enum('page_or_group_or_user', ['page', 'group', 'user']);
            $table->string('page_or_group_or_user_name')->nullable();
            $table->text('message')->nullable();
            $table->text('link')->nullable();
            $table->text('image_url')->nullable();
            $table->text('video_url')->nullable();
            $table->text('video_thumb_url')->nullable();
            $table->enum('auto_share_post', ['0', '1'])->default('0');
            $table->text('auto_share_this_post_by_pages')->nullable();
            $table->enum('posting_status', ['0', '1', '2'])->default('0');
            $table->string('post_id')->nullable();
            $table->text('post_url')->nullable();
            $table->dateTime('schedule_time');
            $table->string('time_zone');
            $table->enum('post_auto_share_cron_jon_status', ['0', '1'])->default('0');
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
        Schema::dropIfExists('facebook_auto_posts');
    }
}
