<?php

namespace App\Domains\Patient\Migrations;

use App\Support\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientTableMigration extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->char('cpf', 11)->unique();
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
        $this->schema->dropIfExists('patients');
    }
}
