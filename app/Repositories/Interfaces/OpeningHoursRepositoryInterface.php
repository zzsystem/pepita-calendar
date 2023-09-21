<?php

namespace App\Repositories\Interfaces;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * OpeningHoursRepositoryInterface interface
 */
interface OpeningHoursRepositoryInterface extends BaseRepositoryInterface
{
    public function getByInterval(string $dateFrom, string $dateTo): \Illuminate\Support\Collection;

    public function validate(InputBag $request): bool;
}