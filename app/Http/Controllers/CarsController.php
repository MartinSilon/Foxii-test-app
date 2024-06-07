<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\Part;
use App\Services\CarService;
use Illuminate\Http\Request;

class CarsController extends Controller
{

    // ---- GENERATING INDEX SCREEN ----
    public function index(Request $request, CarService $carService)
    {
        $cars = $carService->filter($request);
        $count = $cars->count();
        return view('cars.index', compact('cars', 'count'));
    }


    // ---- CREATE AND STORE A NEW CAR ----
    public function store(CreateCarRequest $request)
    {
        Car::create($request->validated());
        return redirect()
            ->route('cars.index')
            ->with('confirmMess', "Vozidlo sa úspešne pridalo do evidencie.");
    }


    // ---- GENERATING EDIT SCREEN ----
    public function edit(Car $car)
    {
        $parts = Part::orderBy('created_at', 'desc')
            ->where('car_id', $car->id)
            ->select('id', 'name', 'serialNumber')
            ->get();
        $count = $parts->count();
        return view('cars.edit', compact('car', 'parts', 'count'));
    }


    // ---- EDIT PART ----
    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());
        return redirect()
            ->route('cars.index')
            ->with('confirmMess', 'Vozidlo bolo úspešne upravené.');
    }


    // ---- DELETING A PART ----
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()
            ->route('cars.index')
            ->with('confirmMess', 'Vozidlo bolo úspešne odstránené.');
    }
}
