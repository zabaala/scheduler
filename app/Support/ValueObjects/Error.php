<?php

namespace App\Support\ValueObjects;

final class Error
{
    /**
     * @var null
     */
    protected $code = null;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var null
     */
    private $type;

    /**
     * Error constructor.
     *
     * @param $messages
     * @param null $code
     * @param null $type
     */
    public function __construct($messages, $code = null, $type = null)
    {
        $this->messages = collect($messages);
        $this->code = $code;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->getCode();
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages->all();
    }

    public function getType()
    {
        return $this->getType();
    }

    /**
     * Count the number total of error messages.
     */
    public function count()
    {
        $this->messages->count();
    }
}
