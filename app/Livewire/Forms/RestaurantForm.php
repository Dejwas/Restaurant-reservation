<?php

declare(strict_types = 1);

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Restaurant;
use Livewire\Attributes\Validate;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class RestaurantForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $name;

    #[Validate('required|string|max:255')]
    public string $address;

    #[Validate('required|numeric|min:1')]
    public ?int $tables;

    public array $tableInfo = [];

    public function store(): RedirectResponse | Redirector
    {
        $this->validate();

        $restaurant = Restaurant::create([
            'name' => $this->name,
            'address' => $this->address
        ]);

        foreach($this->tableInfo as $key => $capacity)
        {
            $restaurant->tables()->create([
                'capacity' => $capacity,
                'table_number' => $key + 1,
            ]);
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant created.');
    }
}
