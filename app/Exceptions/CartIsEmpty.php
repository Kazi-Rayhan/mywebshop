<?php

namespace App\Exceptions;

use Exception;

class CartIsEmpty extends Exception
{
    public $message = "Cart is empty";
}
