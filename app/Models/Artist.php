<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;


class Artist extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'artist';

    protected $fillable = [
        'name',
        'bio',
        'instagram',
        'facebook',
        'wikipedia'
    ];
}
