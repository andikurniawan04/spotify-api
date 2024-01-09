<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;


class Episode extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'episode';

    protected $fillable = [
        'title',
        'description',
        'date',
        'duration',
        'podcast_id',
    ];

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }
}
