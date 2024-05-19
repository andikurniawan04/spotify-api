<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\FollowArtist;
use App\Models\LikedSong;
use App\Models\PodcastEpisode;
use App\Models\SavedEpisode;
use App\Models\Song;
use App\Traits\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseJson;

    public function listFollowArtist()
    {
        $followArtist = FollowArtist::where('user_id', Auth::user()->id)->select('artist_id')->get();

        $artist = Artist::whereIn('id', $followArtist)->select("id", "name", "images")->get();

        $data["total"] = $artist->count();
        $data["data"] = $artist;

        return $this->respondSuccess($data, null, 200);
    }

    public function checkFollowingArtist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $artistId = $request->artist_id;

        $artist = Artist::whereIn('id', $artistId)->pluck('id')->toArray();

        if (count($artist) != count($artistId)) {
            return $this->respondError(null, 'Artist Not Found', 404);
        }

        $followArtist = FollowArtist::where('user_id', Auth::user()->id)->whereIn('artist_id', $artistId)->pluck('artist_id')->toArray();

        $result = [];

        foreach ($artistId as $id) {
            if (in_array($id, $followArtist)) {
                $result[] = true;
            } else {
                $result[] = false;
            }
        }

        return $result;
    }

    public function followArtist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $artistId = $request->artist_id;

        $artist = Artist::whereIn('id', $artistId)->pluck('id')->toArray();

        if (count($artist) != count($artistId)) {
            return $this->respondError(null, 'Artist Not Found', 404);
        }

        foreach ($artistId as $id) {
            $followArtist = FollowArtist::where('user_id', Auth::user()->id)->where('artist_id', $id)->first();

            if (!$followArtist) {
                FollowArtist::create([
                    "user_id" => Auth::user()->id,
                    "artist_id" => $id
                ]);
            }
        }

        return $this->respondSuccess(null, 'Follow the artist was succesfully', 200);
    }

    public function unfollowArtist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $artistId = $request->artist_id;

        $artist = Artist::whereIn('id', $artistId)->pluck('id')->toArray();

        if (count($artist) != count($artistId)) {
            return $this->respondError(null, 'Artist Not Found', 404);
        }

        foreach ($artistId as $id) {
            $followArtist = FollowArtist::where('user_id', Auth::user()->id)->where('artist_id', $id)->first();

            if ($followArtist) {
                $followArtist->delete();
            }
        }

        return $this->respondSuccess(null, 'Unfollow the artist was succesfully', 200);
    }

    public function listLikedSong()
    {
        $likedSong = LikedSong::where('user_id', Auth::user()->id)->select('song_id')->get();

        $song = Song::whereIn('id', $likedSong)->select("id", "title")->get();


        $data["total"] = $song->count();
        $data["data"] = $song;

        return $this->respondSuccess($data, null, 200);
    }

    public function addLikedSong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'song_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $songId = $request->song_id;

        $song = Song::whereIn('id', $songId)->pluck('id')->toArray();

        if (count($song) != count($songId)) {
            return $this->respondError(null, 'Song Not Found', 404);
        }

        foreach ($songId as $id) {
            $likeSong = LikedSong::where('user_id', Auth::user()->id)->where('song_id', $id)->first();

            if (!$likeSong) {
                LikedSong::create([
                    "user_id" => Auth::user()->id,
                    "song_id" => $id
                ]);
            }
        }

        return $this->respondSuccess(null, 'Like song was succesfully', 200);
    }

    public function removeLikedSong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'song_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $songId = $request->song_id;

        $song = Song::whereIn('id', $songId)->pluck('id')->toArray();


        if (count($song) != count($songId)) {
            return $this->respondError(null, 'Song Not Found', 404);
        }

        foreach ($songId as $id) {
            $likeSong = LikedSong::where('user_id', Auth::user()->id)->where('song_id', $id)->first();

            if ($likeSong) {
                $likeSong->delete();
            }
        }

        return $this->respondSuccess(null, 'Remove like song was succesfully', 200);
    }

    public function listSavedEpisode()
    {
        $savedEpisode = SavedEpisode::where('user_id', Auth::user()->id)->select('episode_id')->get();

        $episode = PodcastEpisode::whereIn('id', $savedEpisode)->select("id", "name")->get();

        $data["total"] = $episode->count();
        $data["data"] = $episode;

        return $this->respondSuccess($data, null, 200);
    }

    public function saveEpisode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'episode_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $episodeId = $request->episode_id;

        $episode = PodcastEpisode::whereIn('id', $episodeId)->pluck('id')->toArray();

        if (count($episode) != count($episodeId)) {
            return $this->respondError(null, 'Episode Not Found', 404);
        }

        foreach ($episodeId as $id) {
            $savedEpisode = SavedEpisode::where('user_id', Auth::user()->id)->where('episode_id', $id)->first();

            if (!$savedEpisode) {
                SavedEpisode::create([
                    "user_id" => Auth::user()->id,
                    "episode_id" => $id
                ]);
            }
        }

        return $this->respondSuccess(null, 'Save episode was succesfully', 200);
    }

    public function removeSavedEpisode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'episode_id' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $episodeId = $request->episode_id;

        $episode = PodcastEpisode::whereIn('id', $episodeId)->pluck('id')->toArray();

        if (count($episode) != count($episodeId)) {
            return $this->respondError(null, 'Episode Not Found', 404);
        }

        foreach ($episodeId as $id) {
            $savedEpisode = SavedEpisode::where('user_id', Auth::user()->id)->where('episode_id', $id)->first();

            if ($savedEpisode) {
                $savedEpisode->delete();
            }
        }

        return $this->respondSuccess(null, 'Remove episode song was succesfully', 200);
    }
}
