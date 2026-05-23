<?php

namespace App\Http\Controllers;

use App\Enums\BooleanEnum;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::latest()->paginate(10);
        return view('dashboard.pages.types', compact('types'));
    }

    public function create()
    {
        $categories = Category::where('status', BooleanEnum::TRUE->value)->get();
        return view('dashboard.pages.create-type', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:types,name',
            'description' => 'nullable|string',
        ]);

        Type::create($request->all());
        return redirect()->route('types.index')->with('success', 'Category created successfully!');
    }

    public function show($id)
    {
        $type = Type::findOrFail($id);
        return view('dashboard.pages.type-show', compact('type'));
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        $categories = Category::where('status', BooleanEnum::TRUE->value)->get();
        return view('dashboard.pages.create-type', compact('type', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $type = Type::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255|unique:types,name,' . $id,
                'description' => 'nullable|string',
            ]);

            $type->update($request->all());

            return redirect()->route('types.index')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            return $this->redirectWithError('Error updating type: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $type = Type::findOrFail($id);
            $type->delete();

            return $this->redirectWithSuccess('Type deleted successfully!');
        } catch (\Exception $e) {
            return $this->redirectWithError('Error deleting type: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Type $type): RedirectResponse
    {
        $type->status = $type->status === BooleanEnum::TRUE
            ? BooleanEnum::FALSE
            : BooleanEnum::TRUE;

        $type->save();

        $message = $type->status === BooleanEnum::TRUE
            ? 'Type activated successfully.'
            : 'Type deactivated successfully.';

        return redirect()->back()->with('success', $message);
    }

    public function getCategoryTypes($categoryId)
    {
        return response()->json(Type::active()->where('category_id', $categoryId)->orderBy('id')->get());
    }
}
