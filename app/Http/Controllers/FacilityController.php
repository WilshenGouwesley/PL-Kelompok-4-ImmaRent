<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::query()
            ->where('status', 'active')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->input('category'));
            })
            ->when($request->filled('location'), function ($query) use ($request) {
                $query->where('location', $request->input('location'));
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        return view('facilities.index', [
            'facilities' => $facilities,
        ]);
    }

    public function show(Facility $facility)
    {
        return view('facilities.show', [
            'facility' => $facility,
        ]);
    }
}
