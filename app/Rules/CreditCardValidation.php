<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CreditCardValidation implements Rule
{
    public function passes($attribute, $value)
    {
        
                // Perform validation for each field
        switch ($attribute) {
            case 'card_holder_name':
                // Validate card holder name (e.g., only letters and spaces)
                return preg_match('/^[a-zA-Z ]+$/', $value);

            case 'card_number':
                // Validate credit card number using Luhn algorithm
                // You may also want to check the card type based on the number
                return $this->luhnAlgorithm($value);

            case 'expiration_month':
                // Validate expiration month (e.g., between 1 and 12)
                return is_numeric($value) && $value >= 1 && $value <= 12;

            case 'expiration_year':
                // Validate expiration year (e.g., current year or later)
                return is_numeric($value) && $value >= date('Y');

            case 'ccv':
                // Validate CCV (e.g., three or four digits)
                return preg_match('/^\d{3,4}$/', $value);

            default:
                return false;
        }
    }

    public function message()
    {
        return ':attribute is invalid.';
    }

    private function luhnAlgorithm($number)
    {
        // Implementation of the Luhn algorithm for credit card number validation
        $number = strrev(preg_replace('/[^\d]/', '', $number));
        $sum = 0;

        for ($i = 0, $length = strlen($number); $i < $length; $i++) {
            $digit = (int) $number[$i];

            if ($i % 2 === 1) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 === 0;
    }
}
