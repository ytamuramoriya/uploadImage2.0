<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entidade_id')->index('IN_arquivos_entidade');
            $table->string('nome_entidade')->nullable(false);
            $table->string('nome')->nullable(false);
            $table->string('arquivo')->nullable(true);
            $table->string('extensao')->nullable(true);
            $table->string('mime_type')->nullable(true);
            $table->decimal('tamanho', 22, 2)->nullable(true);
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('arquivos');
    }
}
