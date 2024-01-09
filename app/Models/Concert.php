<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;


class Concert extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'concert';

    protected $fillable = [
        'location',
        'longtitude',
        'latitude',
        'event_at',
        'url_ticket'
    ];
}