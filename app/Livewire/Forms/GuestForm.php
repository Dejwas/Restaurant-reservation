<?php

declare(strict_types = 1);

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class GuestForm extends Form
{
    #[Validate('required|string|max:255')]
    public ?string $firstName = '';

    #[Validate('required|string|max:255')]
    public ?string $lastName = '';

    #[Validate('required|email')]
    public ?string $email = '';

    public function collectData(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email
        ];
    }
}
