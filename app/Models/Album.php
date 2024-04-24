<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

use function PHPSTORM_META\map;

class Album extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'albums';

    protected $fillable = [
        'title',
        'year',
        'thumbnail'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function albumArtist()
    {
        return $this->hasMany(AlbumArtist::class, 'album_id');
    }

    public function artist()
    {
        return $this->hasManyThrough(
            Artist::class,
            AlbumArtist::class,
            'album_id', // Foreign key pada AlbumArtist yang merujuk ke Album
            'id', // Primary key pada Artist yang merujuk ke AlbumArtist
            'id', // Primary key pada Album
            'artist_id' // Foreign key pada AlbumArtist yang merujuk ke Artist
        );
    }
}
