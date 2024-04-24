<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Traits\ResponseJson;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    use ResponseJson;

    public function index($id = "")
    {
        $podcast = Podcast::where('id', $id)->first();

        if (!$podcast) {
            return $this->respondError(null, 'Data Not Found', 404);
        }

        return $this->respondSuccess($podcast, null, 200);
    }
}
