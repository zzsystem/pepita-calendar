<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * BaseRepository class
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */
    public function __construct(
        protected readonly Model $model,
    ) {
    }
}