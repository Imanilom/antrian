<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    // Add the 'loket' attribute to the $fillable array
    protected $fillable = [
        'loket',
        'number',
        'code',
        'status',
    ];

    // If you're using guarded instead of fillable, ensure 'loket' isn't in the guarded array
    protected $guarded = [];
}
