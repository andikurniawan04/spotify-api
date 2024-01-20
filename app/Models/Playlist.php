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

    protected $table = 'playlist';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'user_id'
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
}
