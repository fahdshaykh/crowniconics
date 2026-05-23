<?php

namespace App\Http\Controllers;

use App\Enums\BooleanEnum;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with(['category', 'type'])->latest()->paginate(10);
        return view('dashboard.pages.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('dashboard.pages.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders/images', 'public');
        }

        Slider::create($data);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully!');
    }

    public function show(Slider $slider)
    {
        return view('dashboard.pages.sliders.show', compact('slider'));
    }

    public function edit(Slider $slider)
    {
        // $categories = Category::all();
        // $types = Type::all();
        return view('dashboard.pages.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            // 'category_id' => 'nullable|exists:categories,id',
            // 'type_id' => 'nullable|exists:types,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($slider->image && \Storage::disk('public')->exists($slider->image)) {
                \Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders/images', 'public');
        }

        $slider->update($data);

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image && \Storage::disk('public')->exists($slider->image)) {
            \Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully!');
    }
    public function toggleStatus(Slider $slider): RedirectResponse
    {
        $slider->status = $slider->status === BooleanEnum::TRUE->value
            ? BooleanEnum::FALSE->value
            : BooleanEnum::TRUE->value;

        $slider->save();

        $message = $slider->status === BooleanEnum::TRUE->value
            ? 'Slider activated successfully.'
            : 'Slider deactivated successfully.';

        return redirect()->back()->with('success', $message);
    }
}
