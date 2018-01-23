<?php

namespace App\Domains\Patient\Contracts;

use App\Domains\Patient\Patient;
use Illuminate\Pagination\LengthAwarePaginator;

interface PatientRepositoryInterface
{
    /**
     * PatientRepository constructor.
     *
     * @param Patient $patient
     */
    public function __construct(Patient $patient);

    /**
     * Get all Patients.
     *
     * @return LengthAwarePaginator
     */
    public function getAll();

    /**
     * Create a new patient
     *
     * @param $name
     * @param $email
     * @param $cpf
     * @return bool|Patient
     */
    public function createNewPatient($name, $email, $cpf);

    /**
     * Find a patient by id.
     *
     * @param $id
     * @return mixed
     */
    public function findPatientById($id);

    /**
     * Update a patient by id.
     *
     * @param $id
     * @param $name
     * @param $email
     * @param $cpf
     * @return mixed
     */
    public function updatePatientById($id, $name, $email, $cpf);

    /**
     * Delete a patient by id.
     *
     * @param $id
     * @return bool
     */
    public function deletePatientById($id);
}
