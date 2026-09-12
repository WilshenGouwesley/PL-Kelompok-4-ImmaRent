<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('admin.facilities.index', [
            'facilities' => $facilities,
        ]);
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('facilities', 'public');
        }

        Facility::create($validated);

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Facility added.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', [
            'facility' => $facility,
        ]);
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $this->validated($request);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('facilities', 'public');
        }

        $facility->update($validated);

        return redirect()
            ->route('admin.facilities.index')
            ->with('status', 'Facility updated.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();

        return back()->with('status', 'Facility removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:active,retired'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
