<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MyBlogV110 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_blog_posts', function (Blueprint $table) {
            $table->string('created_from', 100)->nullable()->after('enabled');
        });

        Schema::table('my_blog_comments', function (Blueprint $table) {
            $table->string('created_from', 100)->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
