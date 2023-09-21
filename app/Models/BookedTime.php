<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BookedTime model class
 */
class BookedTime extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'customer_name',
        'start_at',
        'end_at',
    ];

    /**
     * @var array
     */
    protected $dates = ['start_at', 'end_at'];
}