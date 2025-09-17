<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        // Cars list shown in dashboard.blade.php
        $cars = Car::latest()->paginate(10); 
        return view('dashboard', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
        ]);

        Car::create($validated);

        return redirect()->route('dashboard')->with('success', 'Car added successfully.');
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
        ]);

        $car->update($validated);

        return redirect()->route('dashboard')->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('dashboard')->with('success', 'Car deleted successfully.');
    }
}
