<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'officer','is_active', 'queue_limit', 'start_time', 'end_time'
    ];
}
