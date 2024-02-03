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
            $query->select('songs.id', 'title');
        }])->first();

        if (!$playlist) {
            return $this->respondError(null, 'Data Not Found', 404);
        }

        return $this->respondSuccess($playlist, null, 200);
    }
}
