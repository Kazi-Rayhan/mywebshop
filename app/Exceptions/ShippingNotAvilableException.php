<?php

namespace App\Exceptions;

use Exception;

class ShippingNotAvilableException extends Exception
{
   public $message = "We need your checkout information";
}
