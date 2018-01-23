<?php

namespace App\Support\Migration;

use Illuminate\Database\Migrations\Migration as IlluminateMigration;
use Illuminate\Database\Schema\Builder;

abstract class Migration extends IlluminateMigration
{
    /**
     * @var Builder
     */
    protected $schema;

    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    abstract public function up();

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    abstract public function down();
}
