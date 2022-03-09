<?php
namespace App\PaymentGateways\two_checkout\lib\Twocheckout\Api;

use Exception;

class Twocheckout_Error extends Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
