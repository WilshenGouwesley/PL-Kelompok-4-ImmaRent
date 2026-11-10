<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hours = config('school.booking_hours');

        return [
            // hanya fasilitas yang masih aktif (bukan "retired") yang boleh dibooking
            'facility_id' => ['required', Rule::exists('facilities', 'id')->where('status', 'active')],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i', 'after_or_equal:'.$hours['open'], 'before:'.$hours['close']],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time', 'before_or_equal:'.$hours['close']],
            'purpose' => ['required', 'string', 'max:255'],
            'class' => ['required', 'string', Rule::in(config('school.classes'))],
        ];
    }

    public function messages(): array
    {
        $hours = config('school.booking_hours');

        return [
            'start_time.after_or_equal' => "Bookings start from {$hours['open']}.",
            'start_time.before' => "The start time must be before {$hours['close']}.",
            'end_time.before_or_equal' => "Bookings must end by {$hours['close']}.",
            'class.required' => 'Please choose your class.',
            'class.in' => 'Please choose a class from the list.',
        ];
    }

    public function attributes(): array
    {
        return [
            'facility_id' => 'facility',
            'booking_date' => 'date',
            'start_time' => 'start time',
            'end_time' => 'end time',
            'class' => 'class',
        ];
    }

    /**
     * Cek bentrok jadwal setelah aturan dasar lolos, jadi pesan errornya
     * ikut ditampilkan di form dan isian lama tidak hilang.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            // Hari ini: jam mulai harus masih di depan (zona waktu aplikasi).
            if ($this->input('booking_date') === now()->toDateString() && $this->input('start_time') <= now()->format('H:i')) {
                $validator->errors()->add('start_time', 'That start time has already passed today.');

                return;
            }

            $overlaps = Booking::overlapping(
                (int) $this->input('facility_id'),
                $this->input('booking_date'),
                $this->input('start_time'),
                $this->input('end_time'),
            )->exists();

            if ($overlaps) {
                $validator->errors()->add('start_time', 'Fasilitas ini sudah dibooking pada slot waktu tersebut.');
            }
        });
    }
}
