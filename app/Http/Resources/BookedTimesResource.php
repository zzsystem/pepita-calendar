<?php

namespace App\Http\Resources;

use App\Enums\CalendarEventTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * BookedTimesResource class
 */
class BookedTimesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->customer_name,
            'start' => $this->start_at,
            'end' => $this->end_at,
            'display' => CalendarEventTypeEnum::BLOCK->value,
        ];
    }
}
