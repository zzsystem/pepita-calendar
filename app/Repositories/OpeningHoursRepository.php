<?php

namespace App\Repositories;

use App\Enums\CalendarEventTypeEnum;
use App\Enums\OpeningHourReplicationEnum;
use App\Models\OpeningHour;
use App\Repositories\Interfaces\OpeningHoursRepositoryInterface;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * OpeningHoursRepository class
 */
class OpeningHoursRepository extends BaseRepository implements OpeningHoursRepositoryInterface
{
    /**
     * Get all opening hours by interval.
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @return \Illuminate\Support\Collection
     */
    public function getByInterval(string $dateFrom, string $dateTo): \Illuminate\Support\Collection
    {
        $results = collect([]);

        $openingHours = $this->model
            ->where(function ($query) use ($dateTo) {
                $query->whereNull('date_to')
                    ->orWhere('date_to', '>=', $dateTo);
            })
            ->get();

        $period = CarbonPeriod::create($dateFrom, $dateTo);

        foreach ($period as $day) {
            if ($openingHour = $this->checkIfIsActiveDate($day, $openingHours)) {
                $results->push($this->makeDayObject($day, $openingHour));
            }
        }

        return $results;
    }

    /**
     * Validate request.
     *
     * @param InputBag $request
     * @return boolean
     */
    public function validate(InputBag $request): bool
    {
        $startAt = Carbon::parse($request->get('start_at'));
        $endAt = Carbon::parse($request->get('end_at'));
        $openingHours = OpeningHour::where(
            function ($query) use ($endAt) {
                $query->whereNull('date_to')
                    ->orWhere('date_to', '>=', $endAt);
            }
        )->get();

        $openingHour = $this->checkIfIsActiveDate($endAt, $openingHours);

        if ($openingHour) {
            $openingHourStart = $startAt->clone()->setHour($openingHour->start_at);
            $openingHourEnd = $endAt->clone()->setHour($openingHour->end_at);

            return $startAt->gte($openingHourStart) && $endAt->lte($openingHourEnd);
        }

        return false;
    }

    /**
     * Check the date.
     *
     * @param CarbonInterface $date
     * @param mixed $openingHours
     * @return OpeningHour|null
     */
    private function checkIfIsActiveDate(CarbonInterface $date, mixed $openingHours): ?OpeningHour
    {
        if ($date->isWeekend()) {
            return null;
        }

        $justOneTimeDates = $openingHours->where('replication', OpeningHourReplicationEnum::NONE);
        $weekDay = $date->isoWeekday();
        $isOddOrEven = $this->isOddOrEven($date);

        if (in_array($date->toDateString(), $justOneTimeDates->pluck('date_from')->toArray())) {
            return $justOneTimeDates->where('date_from', $date->toDateString())->first();
        }

        foreach ($openingHours as $openingHour) {
            if ($weekDay === $openingHour->day) {
                if (
                    ($isOddOrEven === $openingHour->replication ||
                        $openingHour->replication === OpeningHourReplicationEnum::ALL) && $openingHour->isActive($date)
                ) {
                    return $openingHour;
                }
            }
        }

        return null;
    }

    /**
     * Determines whether the date week is odd or even.
     *
     * @param CarbonInterface $day
     * @return OpeningHourReplicationEnum
     */
    private function isOddOrEven(CarbonInterface $day): OpeningHourReplicationEnum
    {
        return boolval($day->week % 2)
            ? OpeningHourReplicationEnum::ODD
            : OpeningHourReplicationEnum::EVEN;
    }

    /**
     * Returns an array with required data for calendar.
     *
     * @param CarbonInterface $day
     * @param mixed $openingHour
     * @return array
     */
    private function makeDayObject(CarbonInterface $day, mixed $openingHour): array
    {
        return [
            'start' => $day->clone()->setHour($openingHour->start_at)->toDateTimeString(),
            'end' => $day->clone()->setHour($openingHour->end_at)->toDateTimeString(),
            'display' => CalendarEventTypeEnum::BACKGROUND->value,
        ];
    }
}