<?php

namespace App\Support\Validation;

use Illuminate\Contracts\Support\MessageBag;
use Throwable;

class ValidationException extends \Exception
{
    /**
     * @var array
     */
    private $messages;

    /**
     * ValidationException constructor.
     *
     * @param MessageBag $messages
     */
    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages->getMessages();

        parent::__construct("Falidation fails", 400);
    }

    /**
     * Get array with validation fails messages.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
