<?php

namespace App\Rules;

use App\Models\VehicleCategory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidNonAttachmentVehicleCategoryId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $category = VehicleCategory::findOrFail($value);

        if ($category->value === 'attachments') {
            $fail("The {$attribute} is invalid. It must be a valid non-attachment vehicle category id.");
        }
    }
}
