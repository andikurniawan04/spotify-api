<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Traits\ResponseJson;

class SongController extends Controller
{
    use ResponseJson;

    public function index($id = "")
    {
        $song = Song::where('id', $id)->with(['album' => function ($q) {
            
        }, 'artist' => function ($query) {
            $query->select('artists.id', 'name');
        }])->first();

        if (!$song) {
            return $this->respondError(null, 'Data Not Found', 404);
        }

        return $this->respondSuccess($song, null, 200);
    }
}
