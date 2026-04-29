<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use App\Models\EquipmentSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipmentCategoryController extends Controller
{
    /**
     * List all equipment categories
     * 
     * This endpoint retrieves all equipment categories.
     */
    public function showAllEquipmentCategories()
    {
        //
        $categories = EquipmentCategory::get();

        return response()->json($categories);
    }

    /**
     * List all sub categories of an equipment category
     * 
     * This endpoint retrieves all sub categories of an equipment category.
     */
    public function showSubCategories(string $id)
    {
        $subCategories = EquipmentSubCategory::where('category_id', $id)->get();

        return response()->json($subCategories);
    }

    /**
     * Show an equipment sub category
     * 
     * This endpoint retrieves a single equipment sub category.
     */
    public function showSubCategory(string $id)
    {
        $subCategory = EquipmentSubCategory::findOrFail($id);

        return response()->json($subCategory);
    }

    /**
     * Show an equipment category
     * 
     * This endpoint retrieves a single equipment category.
     */
    public function showCategory(string $id)
    {
        $category = EquipmentCategory::findOrFail($id);

        return response()->json($category);
    }

    /**
     * List all equipment sub categories
     * 
     * This endpoint retrieves all equipment sub categories.
     */
    public function showAllEquipmentSubCategories()
    {
        $subCategories = EquipmentSubCategory::get();

        return response()->json($subCategories);
    }

    /**
     * Edit an equipment category
     * 
     * This endpoint edits an equipment category.
     */
    public function editCategory(Request $request, string $id)
    {
        $fields = $request->validate([
            'label' => ['required', 'string'],
        ]);

        $category = EquipmentCategory::findOrFail($id);

        $category->update([
            'label' => $fields['label'],
            'value' => Str::slug($fields['label']),
        ]);

        return response()->json($category);
    }

    /**
     * Delete an equipment category
     * 
     * This endpoint deletes an equipment category.
     */
    public function deleteCategory(string $id)
    {
        $category = EquipmentCategory::findOrFail($id);

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

    /**
     * Add an equipment category
     * 
     * This endpoint adds an equipment category.
     */
    public function addCategory(Request $request)
    {
        $fields = $request->validate([
            'label' => ['required', 'string'],
        ]);

        $category = EquipmentCategory::create([
            'label' => $fields['label'],
            'value' => Str::slug($fields['label']),
        ]);

        return response()->json($category);
    }

    /**
     * Add an equipment sub category
     * 
     * This endpoint adds an equipment sub category.
     * @header Content-Type multipart/form-data
     */
    public function addSubCategory(Request $request)
    {
        $fields = $request->validate([
            'label' => ['required', 'string'],
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'photo' => ['required', 'file'],
        ]);

        $category = EquipmentCategory::findOrFail($fields['category_id']);

        $categoryValue = $category->value;

        $photo = $request->file('photo');

        $subCategory = EquipmentSubCategory::create([
            'label' => $fields['label'],
            'value' => Str::slug($fields['label']),
            'category_id' => $fields['category_id'],
            'photo' => $photo->store("public/ajrli_machines/equipments/$categoryValue"),
        ]);

        return response()->json($subCategory);
    }

    /**
     * Delete an equipment sub category
     * 
     * This endpoint deletes an equipment sub category.
     */
    public function deleteSubCategory(string $id)
    {
        $subCategory = EquipmentSubCategory::findOrFail($id);

        $subCategory->delete();

        return response()->json(['message' => 'Sub category deleted successfully']);
    }

    /**
     * Edit an equipment sub category
     * 
     * This endpoint edits an equipment sub category.
     * @header Content-Type multipart/form-data
     */
    public function editSubCategory(Request $request, string $id)
    {
        $fields = $request->validate([
            'label' => ['string'],
            'photo' => ['file'],
        ]);

        $subCategory = EquipmentSubCategory::findOrFail($id);

        if ($request->has("label")) {
            $subCategory->update([
                'label' => $fields['label'],
                'value' => Str::slug($fields['label']),
            ]);
        }

        if ($request->hasFile("photo")) {
            $photo = $request->file('photo');

            $subCategory->update([
                'photo' => $photo->store("public/ajrli_machines/equipments/{$subCategory->category->value}"),
            ]);
        }

        return response()->json($subCategory);
    }
}
