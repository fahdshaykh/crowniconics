<?php

namespace App\Http\Controllers;

use App\Enums\BooleanEnum;
use App\Models\Category;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $query = Service::latest();

        if (Auth::check() && Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
        $services = $query->paginate(10);
        $categories = Category::where('main_category_id', 2)
            ->where('status', BooleanEnum::TRUE->value)
            ->pluck('name', 'id');

        return view('dashboard.pages.services.index', compact('services', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('main_category_id', 2)
            ->active()
            ->get();

        $types = Type::whereHas('category', function ($query) {
            $query->where('main_category_id', 2)->active();
        })
            ->active()
            ->get();

        return view('dashboard.pages.services.create', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150|unique:services,title',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:types,id',
        ]);

        $data = $request->only(['category_id', 'type_id', 'title', 'description', 'status']);
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($request->title);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }


    public function edit(Service $service)
    {

        $categories = Category::where('main_category_id', 2)
            ->active()
            ->get();

        $types = Type::whereHas('category', function ($query) {
            $query->where('main_category_id', 2)->active();
        })
            ->active()
            ->get();

        return view('dashboard.pages.services.edit', compact('service', 'categories', 'types'));
    }


    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:150|unique:services,title,' . $service->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:types,id',
        ]);

        $data = $request->only(['category_id', 'type_id', 'title', 'description']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function show($id)
    {
        $property = Service::findOrFail($id);
        return view('dashboard.pages.services.show', compact('property'));
    }

    public function destroy(Service $service)
    {
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus($type): RedirectResponse
    {
        $service = Service::findOrFail($type);

        $newStatus = $service->status === BooleanEnum::TRUE
            ? BooleanEnum::FALSE->value
            : BooleanEnum::TRUE->value;

        $service->update(['status' => $newStatus]);

        $message = $newStatus === BooleanEnum::TRUE->value
            ? 'Service activated successfully.'
            : 'Service deactivated successfully.';

        return redirect()->back()->with('success', $message);
    }

    public function getTypes($category_id)
    {
        $types = Type::where('category_id', $category_id)->get();
        return response()->json($types);
    }
}
