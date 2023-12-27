<?php

declare(strict_types = 1);

namespace App\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use App\Livewire\Forms\RestaurantForm;

class CreateRestaurant extends Component
{
    public ?int $defaultTableSeats = 4; 
    public RestaurantForm $form;

    public function updated($property, $value): void
    {
        if($property == "form.tables" && isset($this->form->tables))
        {
            $this->updateTables($value);
        }

        if($property == "defaultTableSeats" && isset($this->defaultTableSeats))
        {
            $this->updateDefaultTables();
        }
    }

    private function updateTables(int $tables): void
    {
        $currentlyDisplayedTables = count($this->form->tableInfo);

        if($currentlyDisplayedTables > $tables)
        {
            $tablesToRemove = $currentlyDisplayedTables - $tables;
            array_splice($this->form->tableInfo, -$tablesToRemove, $tablesToRemove);
        } else 
        {
            $tablesToAdd = array_fill(0, $tables - $currentlyDisplayedTables, $this->defaultTableSeats);
            $this->form->tableInfo = array_merge($this->form->tableInfo, $tablesToAdd);
        }
    }

    private function updateDefaultTables(): void
    {
        array_walk($this->form->tableInfo, fn($value, $key) => $this->form->tableInfo[$key] = $this->defaultTableSeats);
    }

    public function save(): void
    {
        foreach($this->form->tableInfo as $key => $tableCapacity)
        {
            if($tableCapacity == 0 || !is_numeric($tableCapacity)){
                $this->form->tableInfo[$key] = $this->defaultTableSeats;
            }
        }
        
        $this->form->store();
    }

    public function render(): View
    {
        return view('livewire.create-restaurant');
    }
}
