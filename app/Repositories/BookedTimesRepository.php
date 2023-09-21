<?php

namespace App\Repositories;

use App\Http\Requests\SaveBookedTimeRequest;
use App\Models\BookedTime;
use App\Repositories\Interfaces\BookedTimesRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * BookedTimesRepository class
 */
class BookedTimesRepository extends BaseRepository implements BookedTimesRepositoryInterface
{
    /**
     * Get all booked times by interval.
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @return Collection
     */
    public function getByInterval(string $dateFrom, string $dateTo): Collection
    {
        return $this->model->whereBetween('start_at', [$dateFrom, $dateTo])->get();
    }

    /**
     * Save time.
     *
     * @param SaveBookedTimeRequest $request
     * @return BookedTime
     */
    public function save(SaveBookedTimeRequest $request): BookedTime
    {
        return $this->model->create([
            'customer_name' => $request->customer_name,
            'start_at' => Carbon::parse($request->start_at)->toDateTimeString(),
            'end_at' => Carbon::parse($request->end_at)->toDateTimeString(),
        ]);
    }

    /**
     * Validate request date.
     *
     * @param InputBag $request
     * @return boolean
     */
    public function validate(InputBag $request): bool
    {
        return $this->model->where(function ($query) use ($request) {
            $query->where('start_at', '<', $request->get('end_at'))
                ->where('end_at', '>', $request->get('start_at'));
        })->exists();
    }
}