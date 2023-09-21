<?php

namespace App\Enums;

/**
 * CalendarEventTypeEnum
 * 
 * @return int
 */
enum OpeningHourReplicationEnum: int {
    case NONE = 0;
    case ALL = 1;
    case EVEN = 2;
    case ODD = 3;
}