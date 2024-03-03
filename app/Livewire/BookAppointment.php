<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Customer;
use Livewire\Component;

class BookAppointment extends Component
{
    public ?string $alert = null;

    public ?int $appointmentType = null;

    public ?string $appointmentDate = null;

    public iterable $appointmentTypes = [];

    public ?Customer $customer = null;

    public ?Appointment $selectedAppointment = null;

    public array $customerDetails = [
        'name' => '',
        'email' => '',
    ];

    public function mount(): void
    {
        $this->appointmentTypes = \App\Models\AppointmentType::all();
    }

    public function confirmAppointment(): void
    {
        $validated = $this->validate([
            'customerDetails.name' => 'required',
            'customerDetails.email' => 'required|email',
        ]);

        $this->customer->name = $validated['customerDetails']['name'];
        $this->customer->email = $validated['customerDetails']['email'];
        $this->customer->save();

        if ($this->selectedAppointment->confirm($this->customer)) {
            $this->alert = 'Appointment confirmed!';
        } else {
            $this->alert = 'This appointment is no longer available. Please select another one.';
        }

        $this->selectedAppointment = null;
        $this->appointmentDate = null;
        $this->appointmentType = null;
    }

    public function reserveAppointment($appointmentId): void
    {
        $this->customer = new Customer();
        $this->customer->save();

        $this->selectedAppointment = Appointment::find($appointmentId);

        if (! $this->selectedAppointment->reserve($this->customer)) {
            $this->alert = 'This appointment is no longer available. Please select another one.';
            $this->selectedAppointment = null;
            $this->appointmentDate = null;
            $this->appointmentType = null;
        }
    }

    public function clearAlert(): void
    {
        $this->alert = null;
    }

    public function render(): \Illuminate\View\View
    {
        $availableDates = null;
        $availableAppointments = null;

        if ($this->appointmentType) {
            if ($this->appointmentDate) {
                $availableAppointments = Appointment::getAvailableAppointments($this->appointmentType, $this->appointmentDate);
            } else {
                $availableDates = Appointment::getAvailableDates($this->appointmentType);
            }
        }

        return view('livewire.book-appointment', [
            'availableDates' => $availableDates,
            'availableAppointments' => $availableAppointments,
        ]);
    }
}
