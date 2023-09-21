<?php

namespace Database\Seeders;

use App\Enums\OpeningHourReplicationEnum;
use App\Models\OpeningHour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BaseOpeningHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OpeningHour::truncate();

        $openingHours = [
            ['date_from' => Carbon::create(2023, 9, 8)->toDateString(), 'date_to' => null, 'replication' => OpeningHourReplicationEnum::NONE->value, 'day' => null, 'start_at' => '8:00', 'end_at' => '10:00'],
            ['date_from' => Carbon::create(2023, 1, 1)->toDateString(), 'date_to' => null, 'replication' => OpeningHourReplicationEnum::EVEN->value, 'day' => 1, 'start_at' => '10:00', 'end_at' => '12:00'],
            ['date_from' => Carbon::create(2023, 1, 1)->toDateString(), 'date_to' => null, 'replication' => OpeningHourReplicationEnum::ODD->value, 'day' => 3, 'start_at' => '12:00', 'end_at' => '16:00'],
            ['date_from' => Carbon::create(2023, 1, 1)->toDateString(), 'date_to' => null, 'replication' => OpeningHourReplicationEnum::ALL->value, 'day' => 5, 'start_at' => '10:00', 'end_at' => '16:00'],
            ['date_from' => Carbon::create(2023, 6, 1)->toDateString(), 'date_to' => Carbon::create(2023, 11, 30)->toDateString(), 'replication' => OpeningHourReplicationEnum::ALL->value, 'day' => 4, 'start_at' => '16:00', 'end_at' => '20:00'],
        ];

        foreach ($openingHours as $openingHour) {
            OpeningHour::create($openingHour);
        }
    }
}