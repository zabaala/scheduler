<?php

namespace App\Domains\Schedule;

use App\Domains\Doctor\Doctor;
use App\Domains\Patient\Patient;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * Schedule status.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';

    /**
     * Status list for humans.
     *
     * @var array
     */
    public static $arrStatusForHumans = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_CANCELED => 'Canceled',
    ];

    /**
     * Status list for humans.
     *
     * @var array
     */
    public static $arrStatus = [
        self::STATUS_PENDING,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELED,
    ];

    /**
     * Doctors table name.
     *
     * @var string
     */
    public $table = 'schedules';

    /**
     * Fields to be treated as date.
     *
     * @var array
     */
    public $dates = ['created_at', 'updated_at', 'deleted_at', 'date'];

    /**
     * Doctor relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    /**
     * Patient relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
