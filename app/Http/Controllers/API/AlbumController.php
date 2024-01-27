<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Traits\ResponseJson;

class AlbumController extends Controller
{
    use ResponseJson;

    public function index($id = "")
    {
        $album = Album::where('id', $id)->with(['artist' => function ($query) {
            $query->select('artists.id', 'name');
        }])->first();

        if (!$album) {
            return $this->respondError(null, 'Data Not Found', 404);
        }

        return $this->respondSuccess($album, null, 200);
    }
}
