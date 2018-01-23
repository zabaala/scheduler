<?php

namespace App\Domains\Patient;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DbPatientRepository implements PatientRepositoryInterface
{
    /**
    * @var Patient
    */
    private $model;

    /**
     * @var int
     */
    private $perPage = 25;

    /**
     * @param Patient $model
     */
    public function __construct(Patient $model)
    {
        $this->model = $model;
    }

    /**
     * Get all Patients.
     *
     * @return LengthAwarePaginator
     */
    public function getAll()
    {
        return $this
            ->model
            ->newQuery()
            ->select([
                'patients.id',
                'patients.name',
                'patients.email',
                'patients.cpf',
            ])
            ->whereRaw('(patients.deleted_at is null or patients.deleted_at = "")')
            ->paginate($this->perPage);
    }

    /**
     * Create a new patient
     *
     * @param $name
     * @param $email
     * @param $cpf
     * @return bool|Patient
     */
    public function createNewPatient($name, $email, $cpf)
    {
        /** @var  Patient $patient */
        $patient = $this->model;

        $patient->name = $name;
        $patient->email = $email;
        $patient->cpf = $cpf;

        if (!$patient->save()) {
            return false;
        }

        return $patient;
    }

    /**
     * Find a patient by id.
     *
     * @param $id
     * @return mixed
     */
    public function findPatientById($id)
    {
        $patient = $this
            ->model
            ->whereRaw('(patients.deleted_at is null or patients.deleted_at = "")')
            ->whereId($id)
            ->first();

        if (! $patient) {
            throw new ModelNotFoundException("Patient with id: ${id} not found.");
        }

        return $patient;
    }

    /**
     * Update a patient by id.
     *
     * @param $id
     * @param $name
     * @param $email
     * @param $cpf
     * @return mixed
     */
    public function updatePatientById($id, $name, $email, $cpf)
    {
        $patient = $this->findPatientById($id);

        $patient->name = $name;
        $patient->email = $email;
        $patient->cpf = $cpf;

        if (!$patient->save()) {
            return false;
        }

        return $patient;
    }

    /**
     * Delete a patient by id.
     *
     * @param $id
     * @return bool
     */
    public function deletePatientById($id)
    {
        if ($model = $this->findPatientById($id)) {
            $model->deleted_at = now()->toDateTimeString();
            $model->save();
            return true;
        }

        return false;
    }
}
