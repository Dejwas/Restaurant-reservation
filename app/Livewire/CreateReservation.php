<?php

declare(strict_types = 1);

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Table;
use Illuminate\Support\Collection;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\Restaurant;
use App\Livewire\Forms\GuestForm;
use App\Livewire\Forms\ReservationForm;

class CreateReservation extends Component
{
    public Collection $restaurants;
    public int $availableSeats = 0;
    public GuestForm $guestForm;
    public ReservationForm $form;

    public function mount(): void
    {
        $this->restaurants = Restaurant::all(['id', 'name']);
        $this->form->reservationStartTime = Carbon::now()->format('Y-m-d H:i');
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
        if (array_search($propertyName, ['', 'form.restaurantId', 'form.reservationStartTime', 'form.reservationDuration']) &&
            isset($this->form->restaurantId, $this->form->reservationStartTime, $this->form->reservationDuration)) 
        {
            $this->checkAvailableTables();
        }
    }

    public function save(): void
    {
        if(!isset($this->form->restaurantId, $this->form->reservationStartTime, $this->form->reservationDuration))
        {
            $this->form->validate();
        }

        if(!$this->checkAvailableTables()) return;

        if(count($this->form->reservationGuests) > $this->availableSeats) {
            $this->addError('form.reservationGuests', 'Restaurant can only seat ' . $this->availableSeats . ' guests at selected time');
            return;
        }

        $this->form->store();
    }

    public function addGuest(): void
    {
        $this->guestForm->validate();

        if(count($this->form->reservationGuests) >= $this->availableSeats) {
            $this->addError('form.reservationGuests', 'Restaurant can only seat ' . $this->availableSeats . ' guests at selected time');
            return;
        }

        $this->form->reservationGuests[] = $this->guestForm->collectData();

        $this->reset(['guestForm.firstName', 'guestForm.lastName', 'guestForm.email']);
    }

    public function removeGuest(int $index): void
    {
        unset($this->form->reservationGuests[$index]);
        $this->form->reservationGuests = array_values($this->form->reservationGuests);
    }

    private function checkAvailableTables(): bool
    {
        $tables = Table::availableTables(
            $this->form->restaurantId,
            Carbon::parse($this->form->reservationStartTime),
            Carbon::parse($this->form->reservationStartTime)->addHours($this->form->reservationDuration)
        )->select('capacity')->get()->toArray();

        if(count($tables) < 1) 
        {
            $this->addError('form.restaurantId', 'No available tables for selected time');
            $this->availableSeats = 0;
            return false;
        } else {
            $this->resetValidation(['form.restaurantId']);
        }

        $this->availableSeats = array_reduce($tables, function($sum, $item) {
            return $sum + $item['capacity'];
        });

        return true;
    }

    public function render(): View
    {
        return view('livewire.create-reservation');
    }
}
