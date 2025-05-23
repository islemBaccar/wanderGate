<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['trip_id', 'description', 'type', 'expense'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
