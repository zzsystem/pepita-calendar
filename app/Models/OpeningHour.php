<?php

namespace App\Models;

use App\Enums\OpeningHourReplicationEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * OpeningHour class
 */
class OpeningHour extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $casts = [
        'replication' => OpeningHourReplicationEnum::class
    ];

    /**
     * @var array
     */
    protected $dates = ['date_from', 'date_to'];

    /**
     * Check datetime if is in active opening hour.
     *
     * @param CarbonInterface $date
     * @return boolean
     */
    public function isActive(CarbonInterface $date): bool
    {
        if ($this->date_to !== null) {
            return $date->isBetween($this->date_from, $this->date_to);
        }

        return $date->isAfter($this->date_from);
    }
}