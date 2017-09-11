<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBitidNonceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nonces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nonce',128);
            $table->string('qr_code_name',128);
            $table->boolean('verified')->default(0);
            $table->integer('user')->nullable();
            $table->timestamps();
            $table->index('nonce');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nonces');
    }
}
