<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function create(): View
    {
        return view('reservation.create');
    }

    public function show(Reservation $reservation): View
    {
        return view('reservation.show', $reservation);
    }
}
