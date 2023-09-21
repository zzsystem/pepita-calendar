<?php

namespace App\Http\Controllers;

use App\Http\Resources\OpeningHoursResource;
use App\Repositories\Interfaces\OpeningHoursRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * OpeningHoursController class
 */
class OpeningHoursController extends Controller
{
    /**
     * OpeningHoursController constructor
     *
     * @param OpeningHoursRepositoryInterface $openingHoursRepository
     */
    public function __construct(
        private readonly OpeningHoursRepositoryInterface $openingHoursRepository,
    ) {
    }

    /**
     * Retrieve opening hours list.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(
            OpeningHoursResource::collection(
                $this->openingHoursRepository->getByInterval($request->from, $request->to)
            )
        );
    }
}