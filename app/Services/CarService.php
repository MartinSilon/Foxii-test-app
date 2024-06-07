<?php
namespace App\Services;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($request->filled('count')) {
            $count = (int)$request->input('count');

            $query->whereHas('parts', function ($query) use ($count) {
                $query->select('car_id')
                    ->groupBy('car_id')
                    ->havingRaw('count(*) = ?', [$count]);
            });

            // If count is 0, include cars with no parts
            if ($count === 0) {
                $query->orWhereDoesntHave('parts');
            }
        }


        return $query->withCount('parts')->orderByDesc('created_at')->get();
    }
}
