<?php

namespace App\Rules;

use App\Models\VehicleSubCategory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidNonAttachmentVehicleSubCategoryId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $subCategory = VehicleSubCategory::findOrFail($value);

        if ($subCategory->category->value === 'attachments') {
            $fail("The {$attribute} is invalid. It must be a valid non-attachment vehicle subcategory id.");
        }
    }
}
