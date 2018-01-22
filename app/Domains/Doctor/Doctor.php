<?php

namespace App\Domains\Doctor;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * Doctors table name.
     *
     * @var string
     */
    public $table = 'doctors';

    /**
     * Fields to be treated as date.
     *
     * @var array
     */
    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
