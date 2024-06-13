<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Video implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    /* regla para confirmar que el link que se envia en trailer es un link que aceptamos */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strpos($value, 'https://www.youtube.com/watch?v=') !== 0) {
            $fail("El :attribute debe ser un enlace de YouTube válido.");
        }
    }
}
