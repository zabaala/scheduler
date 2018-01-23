<?php

namespace App\Domains\Patient\Providers;

use App\Domains\Patient\Migrations\DropUniqueConstraintFromPatientTable;
use App\Domains\Patient\Migrations\CreatePatientTableMigration;
use Migrator\MigrationServiceProvider;
use Migrator\MigratorTrait;

class PatientMigrationsServiceProvider extends MigrationServiceProvider
{
    use MigratorTrait;

    public function register()
    {
        $this->migrations([
            CreatePatientTableMigration::class,
            DropUniqueConstraintFromPatientTable::class
        ]);
    }
}
