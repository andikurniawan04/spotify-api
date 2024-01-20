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

    protected $table = 'artists';

    protected $fillable = [
        'name',
        'bio',
        'instagram',
        'facebook',
        'wikipedia',
        'images'
    ];

    public function followArtist()
    {
        return $this->hasMany(FollowArtist::class, 'artist_id');
    }

    public function artistSong()
    {
        return $this->hasMany(ArtistSong::class, 'artist_id');
    }

    public function artistConcert()
    {
        return $this->hasMany(ArtistConcert::class, 'artist_id');
    }
}
