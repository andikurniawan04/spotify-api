<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;


class FollowPlaylist extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $table = 'follow_playlist';

    protected $fillable = [
        'playlist_id',
        'user_id'
    ];

    public function playlist()
    {
        return $this->belongsTo(Artist::class, 'playlist_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
