<?php

namespace App\Exceptions;

use Exception;

class UpdateProfileException extends Exception
{
    public $message = "Please update profile and address by clicking edit button then confirm order";
}

