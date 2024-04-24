<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;


class Playlist extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'playlists';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'user_id',
        'image'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function followPlaylist()
    {
        return $this->hasMany(Playlist::class, 'playlist_id');
    }

    public function category()
    {
        return $this->belongsTo(PodcastCategory::class, 'category_id');
    }

    public function song()
    {
        return $this->hasManyThrough(
            Song::class,
            PlaylistSong::class,
            'playlist_id', // Foreign key pada PlaylistSong yang merujuk ke Song
            'id', // Primary key pada Song yang merujuk ke PlaylistSong
            'id', // Primary key pada Playlist
            'song_id' // Foreign key pada PlaylistSong yang merujuk ke Artist
        );
    }
}
