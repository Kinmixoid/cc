<div class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold text-center mb-4">Clevercherry Appointments</h1>

    <!-- Alert should be refactored into its own component -->
    @if($alert)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex" role="alert">
            <span class="block sm:inline">{{ $alert }}</span>
            <button wire:click="clearAlert" type="button" class="ms-auto" >
                x
            </button>
        </div>
    @endif

    @if(!$appointmentType)

        <p class="text-gray-700 text-center mb-6">Choose the type of appointment you need, and let's find a time that works for you.</p>
        <div>
            <label for="appointmentType" class="block text-sm font-medium text-gray-700">Appointment Type</label>
            <select id="appointmentType"
                    wire:model.live="appointmentType"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
                <option value="">Select Appointment Type</option>
                @foreach($appointmentTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name  }}</option>
                @endforeach
            </select>
        </div>
    @else
        @if(!$appointmentDate)
            <p class="text-gray-700 text-center mb-6">Choose the date for your appointment.</p>
            <div>
                <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Appointment date</label>
                <select id="appointmentDate" wire:model.live="appointmentDate"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">Select Appointment Date</option>
                    @foreach($availableDates as $date)
                        <option
                            value="{{ $date->format('Y-m-d') }}"
                        >
                            {{ $date->format('d F') }}
                        </option>
                    @endforeach
                </select>
            </div>
        @else
            @if(!$selectedAppointment)
                <p class="text-gray-700 text-center mb-6">Please select your appointment.</p>
                <div class="flex">
                    @foreach($availableAppointments as $appointment)
                        <button class="border border-gray-300 bg-white rounded-md shadow-sm px-4 py-2 mr-2"
                                wire:click="reserveAppointment({{ $appointment->id }})"
                        >
                            {{ $appointment->date->format('d F') }}
                            {{ $appointment->time }}
                        </button>
                    @endforeach
                </div>
            @else
                <p class="text-gray-700 text-center mb-6">You have selected the following appointment:</p>
                <div class="flex justify-center">
                    {{ $selectedAppointment->date->format('d F') }}
                    {{ $selectedAppointment->time }}
                </div>
                <p class="text-gray-700 text-center mb-6">Please provide your contact details to confirm the booking</p>
                <div class="flex justify-center mt-6">
                    <form wire:submit="confirmAppointment">
                        <input type="text" wire:model="customerDetails.name" class="border border-gray-300 bg-white rounded-md shadow-sm px-4 py-2 mr-2" placeholder="Name">
                        <div>@error('customerDetails.name') {{ $message }} @enderror</div>
                        <input type="email" wire:model="customerDetails.email" class="border border-gray-300 bg-white rounded-md shadow-sm px-4 py-2 mr-2" placeholder="Email">
                        <div>@error('customerDetails.email') {{ $message }} @enderror</div>

                        <button class="bg-indigo-500 text-white px-4 py-2 rounded-md shadow-sm"
                                type="submit"
                        >
                            Confirm Appointment
                        </button>
                    </form>

                </div>
            @endif
        @endif
    @endif


</div>
