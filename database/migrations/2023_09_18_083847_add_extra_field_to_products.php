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
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('sub_sub_category_id')->nullable();
            $table->bigInteger('publisher_id')->nullable();
            $table->string('author_ids')->nullable();
            $table->string('binding')->nullable();
            $table->string('isbn')->nullable();
            $table->string('edition')->nullable();
            $table->date('pubhlishing_date')->nullable();
            $table->string('language')->nullable();
            $table->string('book_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
