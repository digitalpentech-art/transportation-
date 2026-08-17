<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::latest()->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        $availableVehicles = Vehicle::whereNull('route_id')->with('driver')->get();
        return view('admin.routes.create', compact('availableVehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date|after:now',
            'vehicle_ids' => 'nullable|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
        ]);

        $route = Route::create($request->only(['origin', 'destination', 'departure_time']));

        if ($request->has('vehicle_ids')) {
            Vehicle::whereIn('id', $request->vehicle_ids)->update(['route_id' => $route->id]);
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route created successfully.');
    }

    public function edit(Route $route)
    {
        $vehicles = Vehicle::whereNull('route_id')
            ->orWhere('route_id', $route->id)
            ->with('driver')
            ->get();
        return view('admin.routes.edit', compact('route', 'vehicles'));
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'vehicle_ids' => 'nullable|array',
            'vehicle_ids.*' => 'exists:vehicles,id',
        ]);

        $route->update($request->only(['origin', 'destination', 'departure_time']));

        // Unassign vehicles previously on this route that are NOT in the new list
        $vehicleIds = $request->vehicle_ids ?? [];
        Vehicle::where('route_id', $route->id)
            ->whereNotIn('id', $vehicleIds)
            ->update(['route_id' => null]);

        // Assign/Confirm new vehicles
        if (!empty($vehicleIds)) {
            Vehicle::whereIn('id', $vehicleIds)->update(['route_id' => $route->id]);
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return redirect()->route('admin.routes.index')->with('success', 'Route deleted successfully.');
    }
}
