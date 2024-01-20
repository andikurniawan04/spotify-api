<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Song extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'artist';

    protected $fillable = [
        'title',
        'duration',
        'album_id',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function artistSong()
    {
        return $this->hasMany(ArtistSong::class);
    }

    public function likedSong()
    {
        return $this->hasMany(LikedSong::class);
    }
}
