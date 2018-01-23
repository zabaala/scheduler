<?php

namespace App\Domains\Patient\Migrations;

use App\Support\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropUniqueConstraintFromPatientTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->table('patients', function (Blueprint $table) {
            $table->dropUnique('patients_email_unique');
            $table->dropUnique('patients_cpf_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->table('patients', function (Blueprint $table) {
            $table->unique('email');
            $table->unique('cpf');
        });
    }
}
