<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RealEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $email = explode("@",$value);
        $domain = $email[1];
        $domain = $domain . '.';

        if(!isset($email[1]))
        {
            return false;
        }
        else if($domain == 'xyz.com.')
        {
            return false;
        }
        else
        {
            return checkdnsrr($domain,"MX");
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Dominio del correo no válido.';
    }
}
