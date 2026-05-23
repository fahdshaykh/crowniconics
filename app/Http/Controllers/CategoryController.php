<?php

namespace App\Http\Controllers;

use App\Enums\BooleanEnum;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('name');
        $categories = Category::filterName($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();
        
        return view('dashboard.pages.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = MainCategory::get();
        return view('dashboard.pages.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'main_category_id' => 'required|exists:main_categories,id',
        ]);

        $data = $request->all();

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return view('dashboard.pages.categories.show', compact('category'));
    }



    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = MainCategory::get();

        return view('dashboard.pages.create-category', compact('category', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'main_category_id' => 'required|exists:main_categories,id',
        ]);

        $data = $request->all();
        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);

        $category->status = $category->status === BooleanEnum::TRUE
            ? BooleanEnum::FALSE
            : BooleanEnum::TRUE;

        $category->save();

        $message = $category->status === BooleanEnum::TRUE
            ? 'Category activated successfully.'
            : 'Category deactivated successfully.';

        return redirect()->back()->with('success', $message);
    }
}
