<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'officer', 'queue_limit', 'is_active', 'start_time', 'end_time'
    ];
}
