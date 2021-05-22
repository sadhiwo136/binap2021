<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id_prshn');
            $table->string('nama_prshn');
            $table->string('bentuk_prshn');
            $table->string('nama_owner');
            $table->integer('thn_est');
            $table->string('alamat');
            $table->double('lat_prshn');
            $table->double('long_prshn');
            $table->string('telepon');
            $table->string('website');
            $table->string('email');
            $table->timestamps();
            //files
            $table->string('file_akta');
            $table->string('file_foto');
            $table->string('file_ktp');
            //fk
            $table->integer('id_klurahn');
            $table->integer('id_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
