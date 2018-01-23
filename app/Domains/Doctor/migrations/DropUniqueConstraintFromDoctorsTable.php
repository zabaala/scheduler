<?php

namespace App\Domains\Doctor\Migrations;

use App\Support\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropUniqueConstraintFromDoctorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->table('doctors', function (Blueprint $table) {
            $table->dropUnique('doctors_email_unique');
            $table->dropUnique('doctors_cpf_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->table('doctors', function (Blueprint $table) {
            $table->unique('email');
            $table->unique('cpf');
        });
    }
}
