<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Route;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['driver', 'route'])->latest()->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $drivers = User::where('role', 'driver')->get();
        $routes = Route::all();
        return view('admin.vehicles.create', compact('drivers', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_type' => 'required|string|max:255',
            'driver_id' => [
                'required',
                'exists:users,id',
                \Illuminate\Validation\Rule::unique('vehicles', 'driver_id'),
            ],
            'capacity' => 'required|integer|min:1',
            'route_id' => 'nullable|exists:routes,id',
        ]);

        Vehicle::create($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle added successfully.');
    }

    public function edit(Vehicle $vehicle)
    {
        $drivers = User::where('role', 'driver')
            ->where(function ($query) use ($vehicle) {
                $query->whereDoesntHave('vehicle')
                    ->orWhere('id', $vehicle->driver_id);
            })
            ->get();
        $routes = Route::all();
        return view('admin.vehicles.edit', compact('vehicle', 'drivers', 'routes'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'vehicle_type' => 'required|string|max:255',
            'driver_id' => [
                'required',
                'exists:users,id',
                \Illuminate\Validation\Rule::unique('vehicles', 'driver_id')->ignore($vehicle->id),
            ],
            'capacity' => 'required|integer|min:1',
            'route_id' => 'nullable|exists:routes,id',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
