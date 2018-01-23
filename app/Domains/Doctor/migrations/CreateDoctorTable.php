<?php

namespace App\Domains\Doctor\Migrations;

use App\Support\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDoctorTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 60)->unique();
            $table->char('cpf', 11)->unique();
            $table->string('crm', 20);
            $table->string('specialty')->nullable();

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
        $this->schema->dropIfExists('doctors');
    }
}
