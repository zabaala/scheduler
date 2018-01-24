<?php

namespace App\Domains\Patient;

use App\Domains\Patient\Contracts\PatientRepositoryInterface;
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
     * @return \Illuminate\Support\Collection
     */
    public function getAllPluckedUp()
    {
        return $this
            ->model
            ->newQuery()
            ->select([
                'patients.name',
                'patients.id'
            ])
            ->whereNull('deleted_at')
            ->get()
            ->sortBy('name')
            ->pluck('name', 'id');
    }

    /**
     * Get all Patients.
     *
     * @param string $sortBy
     * @param string $orientation
     * @return LengthAwarePaginator
     */
    public function getAll($sortBy = 'name', $orientation = 'asc')
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
            ->whereNull('deleted_at')
            ->orderBy($sortBy, $orientation)
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
