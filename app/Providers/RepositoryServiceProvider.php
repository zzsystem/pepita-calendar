<?php

namespace App\Providers;

use App\Models\BookedTime;
use App\Models\OpeningHour;
use App\Repositories\BookedTimesRepository;
use App\Repositories\Interfaces\BookedTimesRepositoryInterface;
use App\Repositories\Interfaces\OpeningHoursRepositoryInterface;
use App\Repositories\OpeningHoursRepository;
use Illuminate\Support\ServiceProvider;

/**
 * RepositoryServiceProvider class
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OpeningHoursRepositoryInterface::class, fn () => new OpeningHoursRepository(new OpeningHour()));
        $this->app->bind(BookedTimesRepositoryInterface::class, fn () => new BookedTimesRepository(new BookedTime()));
    }
}
