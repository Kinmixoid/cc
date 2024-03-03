<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Appointment;
use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $appointmentTypes = AppointmentType::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Consultation'],
                ['name' => 'Follow-Up'],
                ['name' => 'Evaluation'])
            ->create();

        Appointment::factory()
            ->count(200)
            ->recycle($appointmentTypes)
            ->create();
        Appointment::factory()
            ->confirmed()
            ->count(100)
            ->recycle($appointmentTypes)
            ->create();
        Appointment::factory()
            ->reserved()
            ->count(10)
            ->recycle($appointmentTypes)
            ->create();

    }
}
