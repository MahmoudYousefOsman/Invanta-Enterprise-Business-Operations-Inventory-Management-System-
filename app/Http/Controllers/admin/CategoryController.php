<?php

namespace App\Http\Controllers\admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    public function indexDataTable(CategoriesDataTable $dataTable)
    {
        $permission = Auth::guard("admin")->user();

        return $dataTable->render('admin.categories.index', compact("permission"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categories.*.name' => 'required|string|max:255',
            'categories.*.parent_id' => 'nullable|exists:categories,id',
        ]);

        foreach ($request->categories as $categoryData) {
            $category = new Category();
            $category->name = $categoryData['name'];
            $category->parent_id = $categoryData['parent_id'] ?? null;

            $category->save();
        }

        notyf()->addSuccess("نم اضافه القسم بنجاح");
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $permission = Auth::guard("admin")->user();

        return view('admin.categories.show', compact('category', 'permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::all();
        return view('admin.categories.edit', compact('category', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'categories.*.name' => 'required|string|max:255',
            'categories.*.parent_id' => 'nullable|exists:categories,id',
        ]);

        foreach ($request->categories as $index => $categoryData) {
            if ($index == 0) {
                $updateData = [
                    'name' => $categoryData['name'],
                    'parent_id' => $categoryData['parent_id'] ?? null,
                ];

                $category->update($updateData);
            } else {
                $newCategory = new Category();
                $newCategory->name = $categoryData['name'];
                $newCategory->parent_id = $categoryData['parent_id'] ?? null;
                $newCategory->save();
            }
        }
        notyf()->addSuccess("تم حفظ التعديلات بنجاح");
        return redirect()->route('admin.categories.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Get all category IDs (current and all descendants)
        $allCategoryIds = collect([$category->id])->merge($category->allChildrenIds())->toArray();

        // Check if any products exist in this category or its subcategories
        if (\App\Models\Product::whereIn('category_id', $allCategoryIds)->exists()) {
            notyf()->addError('لا يمكن حذف هذا الفرع لأنه مربوط بمنتجات');
            return redirect()->back();
        }

        $category->delete();

        notyf()->addSuccess('تم الحذف بنجاح');
        return redirect()->route('admin.categories.index');
    }
    public function getSubCategories($id)
    {
        $subcategories = Category::where('parent_id', $id)->get();
        return response()->json($subcategories);
    }

}
