<?php

namespace App\Support\Command;

use App\Support\ValueObjects\Error;
use Illuminate\Support\MessageBag;

class CommandException extends \Exception
{
    /**
     * @var Error
     */
    private $error;

    /**
     * CommandException constructor.
     *
     * @param array $errors
     * @param string $message
     * @param string $type
     * @param int $code
     */
    public function __construct($errors, $message = "", $type = "", $code = 0)
    {
        $this->error = new MessageBag($errors);

        $messages = collect($errors)->flatten()->toArray();

        $message = sprintf(
            '%s',
            implode(' ', $messages)
        );

        parent::__construct($message, $code, null);
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }
}
