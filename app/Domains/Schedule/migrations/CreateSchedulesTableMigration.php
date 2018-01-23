<?php

namespace App\Domains\Schedule\Migrations;

use App\Support\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSchedulesTableMigration extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('patient_id');
            $table->enum('status', ['pending', 'completed', 'canceled']);
            $table->dateTime('date');
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('schedules');
    }
}
