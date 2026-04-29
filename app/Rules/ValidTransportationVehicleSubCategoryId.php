<?php

namespace App\Rules;

use App\Models\VehicleSubCategory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTransportationVehicleSubCategoryId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $subCategory = VehicleSubCategory::findOrFail($value)->load('category');

        if ($subCategory->category->value !== 'service-transport') {
            $fail("The {$attribute} is invalid. It must be a valid transportation service subcategory id.");
        }
    }
}
