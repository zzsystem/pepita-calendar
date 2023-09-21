<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\BookedTimesRepositoryInterface;
use App\Repositories\Interfaces\OpeningHoursRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * SaveBookedTimeRequest class
 */
class SaveBookedTimeRequest extends FormRequest
{
    /**
     * SaveBookedTimeRequest contructor
     *
     * @param OpeningHoursRepositoryInterface $openingHourRepository
     * @param BookedTimesRepositoryInterface $bookedTimesRepository
     */
    public function __construct(
        private readonly OpeningHoursRepositoryInterface $openingHourRepository,
        private readonly BookedTimesRepositoryInterface $bookedTimesRepository,
    ) {
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string'],
            'start_at' => ['required', 'date', 'is_active', 'is_booked'],
            'end_at' => ['required', 'date'],
        ];
    }

    /**
     * Extend validator.
     *
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->addExtension('is_active', function ($attribute, $value, $parameters, $validator) {
            return $this->openingHourRepository->validate($this->request);
        });

        $validator->addExtension('is_booked', function ($attribute, $value, $parameters, $validator) {
            return !$this->bookedTimesRepository->validate($this->request);
        });
    }
}