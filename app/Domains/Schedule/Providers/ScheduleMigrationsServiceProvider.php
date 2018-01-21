<?php

namespace App\Domains\Schedule\Providers;

use App\Domains\Schedule\Migrations\CreateSchedulesTableMigration;
use Migrator\MigrationServiceProvider;
use Migrator\MigratorTrait;

class ScheduleMigrationsServiceProvider extends MigrationServiceProvider
{
    use MigratorTrait;

    public function register()
    {
        $this->migrations([
            CreateSchedulesTableMigration::class
        ]);
    }
}
