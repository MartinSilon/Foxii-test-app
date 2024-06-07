<?php
namespace App\Services;

use App\Models\Part;
use Illuminate\Http\Request;

class PartService
{
    // ---- FILTER FOR PARTS ----
    public function filter(Request $request)
    {
        $query = Part::query();

        // ---- FILTER BY NAME, SERIAL NR. ----
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('serialNumber', 'like', "%$searchTerm%")
                    ->orWhere('name', 'like', "%$searchTerm%");
            });
        }

        // ---- USED OR FREE PART FILTER ----
        if ($request->filled('usedOnCar')) {
            $isUsed = $request->boolean('usedOnCar');
            if ($isUsed) {
                $query->whereNotNull('car_id');
            } else {
                $query->whereNull('car_id');
            }
        }

        return $query->with('car')->orderByDesc('created_at')->get();
    }
}
