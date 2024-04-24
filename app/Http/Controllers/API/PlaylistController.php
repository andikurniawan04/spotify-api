<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Traits\ResponseJson;

class PlaylistController extends Controller
{
    use ResponseJson;

    public function index($id = "")
    {
        $playlist = Playlist::where('id', $id)->with(['song' => function ($query) {
            $query->with(['artist' => function ($query) {
                $query->select('artists.id', 'name');
            }])->select('songs.id', 'title');
        }, 'user' => function ($q) {
            $q->select('id', 'name');
        }])->first();

        if (!$playlist) {
            return $this->respondError(null, 'Data Not Found', 404);
        }

        return $this->respondSuccess($playlist, null, 200);
    }
}
