<?php

declare(strict_types = 1);

namespace App\Livewire\Forms;

use Carbon\Carbon;
use Livewire\Form;
use App\Models\Table;
use App\Models\Reservation;
use App\Models\ReservationGuest;
use App\Models\ReservationTable;
use Livewire\Attributes\Validate;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class ReservationForm extends Form
{
    #[Validate('required|exists:restaurants,id')]
    public int $restaurantId;

    #[Validate('required|date')]
    public string $reservationStartTime;

    #[Validate('required|numeric')]
    public ?int $reservationDuration = 1;

    #[Validate('required|string|max:255')]
    public string $firstName = '';

    #[Validate('required|string|max:255')]
    public string $lastName = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10')]
    public string $phone = '';

    #[Validate('required')]
    public array $reservationGuests = [];

    public function store(): RedirectResponse | Redirector
    {
        $reservation = Reservation::create([
            'contact_first_name' => $this->firstName,
            'contact_last_name' => $this->lastName,
            'contact_email' => $this->email,
            'contact_phone' => $this->phone,
            'reservation_start_time' => Carbon::parse($this->reservationStartTime),
            'reservation_end_time' => Carbon::parse($this->reservationStartTime)
                ->addHours($this->reservationDuration)
                ->format('Y-m-d H:i'),
            'restaurant_id' => $this->restaurantId 
        ]);

        foreach($this->reservationGuests as $guest) {
            ReservationGuest::create([
                'first_name' => $guest['firstName'],
                'last_name' => $guest['lastName'],
                'email' => $guest['email'],
                'reservation_id' => $reservation->id 
            ]);
        }

        $availableTables = Table::availableTables(
            $this->restaurantId,
            Carbon::parse($reservation->reservation_start_time),
            Carbon::parse($reservation->reservation_end_time))
            ->select(['id', 'capacity'])
            ->orderBy('capacity')
            ->get()
            ->toArray();

        $tableIds = $this->getTables($availableTables, count($this->reservationGuests));

        foreach($tableIds as $tableId) {
            ReservationTable::create([
                'table_id' => $tableId,
                'reservation_id' => $reservation->id
            ]);
        }

        return redirect()->route('reservations.show', ['reservation' => $reservation])->with('success', 'Reservation created.');
    }

    //Available tables should be ordered by capacity
    private function getTables(array $availableTables, int $numberOfGuests): array
    {
        $tableIds = [];

        //Try to find single table
        foreach($availableTables as $availableTable)
        {
            if($availableTable['capacity'] >= $numberOfGuests)
            {
                return [$availableTable['id']];
            }
        }

        //If single table does not exist, assign the largest table and repeat
        $largestTable = end($availableTables);
        $tableIds[] = $largestTable['id'];

        array_splice($availableTables, -1, 1);
        $remainingNumberOfGuests = $numberOfGuests - $largestTable['capacity'];

        $remainingTableIds = $this->getTables($availableTables, (int)$remainingNumberOfGuests);

        foreach($remainingTableIds as $tableId)
        {
            $tableIds[] = $tableId;
        }

        return $tableIds;
    }
}
