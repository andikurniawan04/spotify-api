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

    protected $table = 'songs';

    protected $fillable = [
        'title',
        'duration',
        'album_id',
    ];

    protected $hidden = [
        'album_id',
        'laravel_through_key',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // public function artistSong()
    // {
    //     return $this->hasMany(ArtistSong::class);
    // }

    public function likedSong()
    {
        return $this->hasMany(LikedSong::class);
    }

    public function artist()
    {
        return $this->hasManyThrough(
            Artist::class,
            ArtistSong::class,
            'song_id', // Foreign key pada ArtistSong yang merujuk ke Song
            'id', // Primary key pada Artist yang merujuk ke ArtistSong
            'id', // Primary key pada Song
            'artist_id' // Foreign key pada ArtistSong yang merujuk ke Artist
        );
    }
}
