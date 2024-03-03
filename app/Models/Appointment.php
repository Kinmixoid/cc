<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'status',
        'appointment_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'status' => AppointmentStatus::class,
        'appointment_type_id' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->BelongsTo(Customer::class);
    }

    public function appointmentType(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public function reserve(Customer $customer): bool
    {
        if ($this->status != AppointmentStatus::Available) {
            return false;
        }

        $this->status = AppointmentStatus::Reserved;
        $this->customer_id = $customer->id;
        $this->save();

        return true;
    }

    public function confirm(Customer $customer): bool
    {
        if ($this->status != AppointmentStatus::Reserved || $this->customer_id != $customer->id) {
            return false;
        }

        $this->status = AppointmentStatus::Confirmed;
        $this->save();

        // Send confirmation email to the customer

        return true;
    }

    public static function getAvailableAppointments(int $appointmentTypeId, string $date): iterable
    {
        return static::where('appointment_type_id', $appointmentTypeId)
            ->where('date', $date)
            ->where('status', AppointmentStatus::Available)
            ->orderBy('time')
            ->get();
    }

    public static function getAvailableDates(int $appointmentTypeId): iterable
    {
        return static::where('appointment_type_id', $appointmentTypeId)
            ->where('status', AppointmentStatus::Available)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('date');
    }
}
