<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::latest()->get();
        return view('restaurant.index', compact('restaurants'));
    }

    public function create()
    {
        return view('restaurant.create');
    }

    public function show(Restaurant $restaurant)
    {
        return view('restaurant.show', ['restaurant' => $restaurant->load(['upcomingReservations', 'pastReservations', 'reservations.reservationTables'])]);
    }
}
