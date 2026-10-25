<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveFacilityRequest;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::query()
            ->filter($request->only('search'))
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

    public function store(SaveFacilityRequest $request)
    {
        $validated = $request->validated();

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

    public function update(SaveFacilityRequest $request, Facility $facility)
    {
        $validated = $request->validated();

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
}
