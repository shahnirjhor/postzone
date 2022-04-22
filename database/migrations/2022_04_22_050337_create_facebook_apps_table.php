<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_apps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(false);
            $table->string('api_id');
            $table->string('app_name')->nullable();
            $table->string('api_secret');
            $table->string('numeric_id')->nullable();
            $table->string('user_access_token')->nullable();
            $table->boolean('developer_access')->default(false);
            $table->string('facebook_id')->nullable();
            $table->string('secret_code')->nullable();
            $table->enum('use_by', ['only_me', 'everyone'])->default('only_me');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('facebook_apps');
    }
}
