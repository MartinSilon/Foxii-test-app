<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;

class CarService
{
    // ---- FILTER FOR PARTS ----
    public function filter(Request $request)
    {
        // rules for RANGE
        $validatedData = $request->validate([
            'range' => 'nullable|regex:/^\d+(-\d+)?$/'
        ], [
            'range.regex' => 'Zle zadané parametre rozsahu, použite číslo napr. "1" alebo rozsah "1-10".'
        ]);

        $query = Car::query();

        // ---- FILTER BY NAME, REGISTER NR. ----
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('registration_number', 'like', "%$searchTerm%")
                    ->orWhere('name', 'like', "%$searchTerm%");
            });
        }

        // ---- REGISTERED FILTER ----
        if ($request->filled('registered')) {
            $isRegistered = $request->boolean('registered');
            $query->where('is_registered', $isRegistered);
        }

        // ---- PART COUNT FILTER ----
        if ($request->filled('range')) {
            $count = $request->input('range');

            if (strpos($count, '-')) {
                [$min, $max] = array_map('intval', explode('-', $count));

                $query->whereHas('parts', function ($query) use ($min, $max) {
                    $query->havingRaw('COUNT(*) BETWEEN ? AND ?', [$min, $max]);
                });
            } else {
                $query->whereHas('parts', function ($query) use ($count) {
                    $query->havingRaw('COUNT(id) = ?', [$count]);
                });
            }
        }

        return $query->withCount('parts')->orderByDesc('created_at')->get();
    }
}
