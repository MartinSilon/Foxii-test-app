<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePartRequest;
use App\Http\Requests\UpdatePartRequest;
use Illuminate\Http\Request;
use App\Services\PartService;
use App\Models\Part;
use App\Models\Car;

class PartsController extends Controller
{

    // ---- TO FETCH CARS ----
    protected function getCars()
    {
        return Car::orderBy('created_at', 'desc')
            ->select('id', 'name', 'registration_number')
            ->get();
    }


    // ---- GENERATING INDEX SCREEN ----
    public function index(Request $request, PartService $partService)
    {
        $parts = $partService->filter($request);
        $cars = $this->getCars();
        $count = $parts->count();
        return view('parts.index', compact('parts', 'cars', 'count'));
    }


    // ---- CREATE AND STORE A NEW PART ----
    public function store(CreatePartRequest $request)
    {
        Part::create($request->validated());
        return redirect()
            ->back()
            ->with('confirmMess', "Diel sa úspešne pridal do zoznámu dielov.");
    }


    // ---- GENERATING EDIT SCREEN ----
    public function edit(Part $part)
    {
        $cars = $this->getCars();
        return view('parts.edit', compact('part', 'cars' ));
    }


    // ---- EDIT PART ----
    public function update(UpdatePartRequest $request, Part $part)
    {
        $part->update($request->validated());
        return redirect()
            ->route('parts.index')
            ->with('confirmMess', 'Diel bol úspešne upravený.');
    }


    // ---- DELETING A PART ----
    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()
            ->route('parts.index')
            ->with('confirmMess', 'Diel bol úspešne odstránený.');
    }


    // ---- REMOVE PART FROM VEHICLE ----
    public function removeFromVehicle(Part $part)
    {
        $part->update(['car_id' => null]);
        return redirect()
            ->back()
            ->with('confirmMess', "Diel sa úspešne odpojil od vozidla.");
    }
}
