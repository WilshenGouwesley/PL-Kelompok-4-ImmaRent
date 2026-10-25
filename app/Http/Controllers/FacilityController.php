<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::query()
            ->active()
            ->filter($request->only(['search', 'category', 'location']))
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
