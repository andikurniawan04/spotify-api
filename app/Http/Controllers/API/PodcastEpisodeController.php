<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PodcastEpisode;
use App\Traits\ResponseJson;
use Illuminate\Http\Request;

class PodcastEpisodeController extends Controller
{
    use ResponseJson;

    public function index($id = "")
    {
        $podcast = PodcastEpisode::join('podcasts as pd', 'ep.podcast_id', 'pd.id')
            ->join('users', 'pd.user_id', 'users.id')
            ->from('podcast_episodes as ep')
            ->select('ep.name', 'ep.description', 'ep.image', 'ep.description', 'ep.duration_ms', 'ep.file', 'pd.name as podcast_name', 'users.name as publisher')
            ->where('ep.id', $id)->first();

        if (!$podcast) {
            return $this->respondError(null, 'Data Not Found', 404);
        }

        return $this->respondSuccess($podcast, null, 200);
    }
}
