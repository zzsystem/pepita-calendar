<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveBookedTimeRequest;
use App\Http\Resources\BookedTimesResource;
use App\Repositories\Interfaces\BookedTimesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * BookedTimesController class
 */
class BookedTimesController extends Controller
{
    /**
     * BookedTimesController constructor
     *
     * @param BookedTimesRepositoryInterface $bookedTimesRepository
     */
    public function __construct(
        private readonly BookedTimesRepositoryInterface $bookedTimesRepository,
    ) {
    }

    /**
     * Get all booked times.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            BookedTimesResource::collection($this->bookedTimesRepository->getByInterval($request->from, $request->to))
        );
    }

    /**
     * Save time.
     *
     * @param SaveBookedTimeRequest $request
     * @return JsonResponse
     */
    public function save(SaveBookedTimeRequest $request): JsonResponse
    {
        $bookedTime = $this->bookedTimesRepository->save($request);

        return response()->json(
            new BookedTimesResource($bookedTime)
        );
    }
}
