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
            $table->string('campaign_name')->nullable();
            $table->string('page_group_user_id');
            $table->enum('page_or_group_or_user', ['page', 'group', 'user']);
            $table->string('cta_type');
            $table->text('cta_value');
            $table->text('message');
            $table->text('link');
            $table->enum('posting_status', ['0', '1', '2'])->default('0');
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
