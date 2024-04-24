<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\FollowArtist;
use App\Models\LikedSong;
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

    public function followArtist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $artist = Artist::where('id', $request->artist_id)->first();

        if (!$artist) {
            return $this->respondError(null, 'Artist Not Found', 404);
        }

        $followArtist = FollowArtist::where('user_id', Auth::user()->id)->where('artist_id', $artist->id)->first();

        if ($followArtist) {
            return $this->respondSuccess(null, 'User is aiready follow the artist', 200);
        }

        FollowArtist::create([
            "user_id" => Auth::user()->id,
            "artist_id" => $artist->id
        ]);

        return $this->respondSuccess(null, 'Follow the artist was succesfully', 200);
    }

    public function unfollowArtist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'artist_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $artist = Artist::where('id', $request->artist_id)->first();

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $artist = Artist::where('id', $request->artist_id)->first();

        if (!$artist) {
            return $this->respondError(null, 'Artist Not Found', 404);
        }

        $unfollowArtist = FollowArtist::where('user_id', Auth::user()->id)->where('artist_id', $artist->id)->first();

        if (!$unfollowArtist) {
            return $this->respondSuccess(null, 'User is aiready unfollow the artist', 200);
        }

        $unfollowArtist->delete();

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
            'song_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $song = Song::where('id', $request->song_id)->first();

        if (!$song) {
            return $this->respondError(null, 'Song Not Found', 404);
        }

        $likeSong = LikedSong::where('user_id', Auth::user()->id)->where('song_id', $song->id)->first();

        if ($likeSong) {
            return $this->respondSuccess(null, 'User is aiready like the song', 200);
        }

        LikedSong::create([
            "user_id" => Auth::user()->id,
            "song_id" => $song->id
        ]);

        return $this->respondSuccess(null, 'Like song was succesfully', 200);
    }

    public function removeLikedSong(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'song_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 'Validation Error', 422);
        }

        $song = Song::where('id', $request->song_id)->first();

        if (!$song) {
            return $this->respondError(null, 'Song Not Found', 404);
        }

        $likeSong = LikedSong::where('user_id', Auth::user()->id)->where('song_id', $song->id)->first();

        if (!$likeSong) {
            return $this->respondSuccess(null, 'User is aiready remove the like from the song', 200);
        }

        $likeSong->delete();

        return $this->respondSuccess(null, 'Remove like song was succesfully', 200);
    }

    public function listSavedEpisode()
    {
        return "episode";
    }

    public function saveEpisode()
    {
        return 'andi';
    }

    public function removeSavedEpisode()
    {
        return "remove";
    }
}
