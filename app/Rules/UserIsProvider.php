<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserIsProvider implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $user = User::findOrFail($value);

        if (!$user->user_type === 'provider_individual' && !$user->user_type === 'provider_society') {
            $fail("The user with id $value is not a user of type provider.");
        }
    }
}
