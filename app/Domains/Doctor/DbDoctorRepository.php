<?php

namespace App\Domains\Doctor;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class DbDoctorRepository
{
    /**
     * @var Doctor
     */
    private $model;

    /**
     * @var int
     */
    private $perPage = 25;

    /**
     * @param Doctor $model
     */
    public function __construct(Doctor $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this
            ->model
            ->newQuery()
            ->select([
                'doctors.id',
                'doctors.name',
                'doctors.email',
                'doctors.cpf',
            ])
            ->whereRaw('(doctors.deleted_at is null or doctors.deleted_at = "")')
            ->paginate($this->perPage);
    }

    /**
     * @param $name
     * @param $email
     * @param $cpf
     * @param $crm
     * @param null $specialty
     * @return bool|Doctor
     */
    public function createNewDoctor($name, $email, $cpf, $crm, $specialty = null)
    {
        /** @var  Doctor $doctor */
        $doctor = $this->model;

        $doctor->name = $name;
        $doctor->email = $email;
        $doctor->cpf = $cpf;
        $doctor->crm = $crm;
        $doctor->specialty = $specialty;

        if (!$doctor->save()) {
            return false;
        }

        return $doctor;
    }

    /**
     * Find a doctor by id.
     *
     * @param $id
     * @return mixed
     */
    public function findDoctorById($id)
    {
        $doctor = $this
            ->model
            ->whereRaw('(doctors.deleted_at is null or doctors.deleted_at = "")')
            ->whereId($id)
            ->first();

        if (! $doctor) {
            throw new ModelNotFoundException("Doctor with id: ${id} not found.");
        }

        return $doctor;
    }

    /**
     * @param $id
     * @param $name
     * @param $email
     * @param $cpf
     * @param $crm
     * @param null $specialty
     * @return mixed
     */
    public function updateDoctorById($id, $name, $email, $cpf, $crm, $specialty = null)
    {
        $doctor = $this->findDoctorById($id);

        $doctor->name = $name;
        $doctor->email = $email;
        $doctor->cpf = $cpf;
        $doctor->crm = $crm;
        $doctor->specialty = $specialty;

        if (!$doctor->save()) {
            return false;
        }

        return $doctor;
    }

    /**
     *
     * @param $id
     * @return bool
     */
    public function deleteDoctorById($id)
    {
        if ($model = $this->findDoctorById($id)) {
            $model->deleted_at = now()->toDateTimeString();
            $model->save();
            return true;
        }

        return false;
    }
}
