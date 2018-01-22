<?php

namespace App\Support\Command;

use App\Support\Validation\ValidationException;
use App\Support\ValueObjects\Error;

abstract class Command
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var bool
     */
    protected $fails = false;

    /**
     * @var Error
     */
    private $error;

    /**
     * Command constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        $this->validate();
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        $method = 'validation';

        if (! method_exists($this, $method)) {
            return true;
        }

        try {
            $class = $this->$method();
            (new $class($this->data))->validate();
        } catch (ValidationException $validationException) {
            $this->error = new Error(
                $validationException->getMessages(),
                $validationException->getCode(),
                ValidationException::class);

            $this->fails = true;
        }
    }

    /**
     * @return bool
     */
    public function fails()
    {
        return $this->fails;
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }


    /**
     * Handle the command.
     *
     * @return mixed
     */
    abstract public function handle();


}
