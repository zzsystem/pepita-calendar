<?php

namespace App\Repositories\Interfaces;
use App\Http\Requests\SaveBookedTimeRequest;
use App\Models\BookedTime;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * BookedTimesRepositoryInterface interface
 */
interface BookedTimesRepositoryInterface extends BaseRepositoryInterface
{
    public function getByInterval(string $dateFrom, string $dateTo): Collection;

    public function save(SaveBookedTimeRequest $request): BookedTime;

    public function validate(InputBag $request): bool;
}