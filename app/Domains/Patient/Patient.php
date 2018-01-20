<?php

namespace App\Domains\Patient;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * Doctors table name.
     *
     * @var string
     */
    public $table = 'patients';

    /**
     * Fields to be treated as date.
     *
     * @var array
     */
    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
