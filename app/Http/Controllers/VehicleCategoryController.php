<?php

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleCategoryController extends Controller
{
    /**
     * List all vehicle categories
     * 
     * This endpoint retrieves all vehicle categories.
     */
    public function showAllVehicleCategories()
    {
        //
        $categories = VehicleCategory::get();

        return response()->json($categories);
    }

    /**
     * List all sub categories of a vehicle category
     * 
     * This endpoint retrieves all sub categories of a vehicle category.
     */
    public function showSubCategories(string $id)
    {
        $subCategories = VehicleSubCategory::where('category_id', $id)->get();

        return response()->json($subCategories);
    }

    /**
     * Show a vehicle sub category
     * 
     * This endpoint retrieves a single vehicle sub category.
     */
    public function showSubCategory(string $id)
    {
        $subCategory = VehicleSubCategory::findOrFail($id);

        return response()->json($subCategory);
    }

    /**
     * Show a vehicle category
     * 
     * This endpoint retrieves a single vehicle category.
     */
    public function showCategory(string $id)
    {
        $category = VehicleCategory::findOrFail($id);

        return response()->json($category);
    }

    /**
     * List all vehicle sub categories
     * 
     * This endpoint retrieves all vehicle sub categories.
     */
    public function showAllVehicleSubCategories()
    {
        $subCategories = VehicleSubCategory::get();

        return response()->json($subCategories);
    }

    /**
     * Edit a vehicle category
     * 
     * This endpoint edits a vehicle category.
     */
    public function editCategory(Request $request, string $id)
    {
        $fields = $request->validate([
            'label' => ['required', 'string'],
        ]);

        $category = VehicleCategory::findOrFail($id);

        $category->update([
            'label' => $fields['label'],
            'value' => Str::slug($fields['label']),
        ]);

        return response()->json($category);
    }

    /**
     * Delete a vehicle category
     * 
     * This endpoint deletes a vehicle category.
     */
    public function deleteCategory(string $id)
    {
        $category = VehicleCategory::findOrFail($id);

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

    /**
     * Add a vehicle category
     * 
     * This endpoint adds a vehicle category.
     */
    public function addCategory(Request $request)
    {
        $fields = $request->validate([
            'label' => ['required', 'string'],
        ]);

        $category = VehicleCategory::create([
            'label' => $fields['label'],
            'value' => Str::slug($fields['label']),
        ]);

        return response()->json($category);
    }

    /**
     * Add a vehicle sub category
     * 
     * This endpoint adds a vehicle sub category.
     * @header Content-Type multipart/form-data
     */
    public function addSubCategory(Request $request)
    {
        $fields = $request->validate([
            'label' => ['required', 'string'],
            'category_id' => ['required', 'exists:vehicle_categories,id'],
            'photo' => ['required', 'file'],
        ]);

        $category = VehicleCategory::findOrFail($fields['category_id']);

        $categoryValue = $category->value;

        $photo = $request->file('photo');

        $subCategory = VehicleSubCategory::create([
            'label' => $fields['label'],
            'value' => Str::slug($fields['label']),
            'category_id' => $fields['category_id'],
            'photo' => $photo->store("public/ajrli_machines/vehicles/$categoryValue"),
        ]);

        return response()->json($subCategory);
    }

    /**
     * Delete a vehicle sub category
     * 
     * This endpoint deletes a vehicle sub category.
     */
    public function deleteSubCategory(string $id)
    {
        $subCategory = VehicleSubCategory::findOrFail($id);

        $subCategory->delete();

        return response()->json(['message' => 'Sub category deleted successfully']);
    }

    /**
     * Edit a vehicle sub category
     * 
     * This endpoint edits a vehicle sub category.
     * @header Content-Type multipart/form-data
     */
    public function editSubCategory(Request $request, string $id)
    {
        $fields = $request->validate([
            'label' => ['string'],
            'photo' => ['file'],
        ]);

        $subCategory = VehicleSubCategory::findOrFail($id);

        if ($request->has("label")) {
            $subCategory->update([
                'label' => $fields['label'],
                'value' => Str::slug($fields['label']),
            ]);
        }

        if ($request->hasFile("photo")) {
            $photo = $request->file('photo');

            $subCategory->update([
                'photo' => $photo->store("public/ajrli_machines/vehicles/{$subCategory->category->value}"),
            ]);
        }

        return response()->json($subCategory);
    }
}
