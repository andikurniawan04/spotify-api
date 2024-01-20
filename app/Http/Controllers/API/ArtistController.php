<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Traits\ResponseJson;

class ArtistController extends Controller
{
    use ResponseJson;

    public function index($id = "")
    {
        $data = Artist::where('id', $id)->first();

        if (!$data) {
            return $this->respondError(null, 'Data Not Found', 404);
        }

        return $this->respondSuccess($data, null, 200);
    }
}
