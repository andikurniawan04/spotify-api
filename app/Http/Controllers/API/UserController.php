<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\FollowArtist;
use App\Traits\ResponseJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseJson;

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

        return $this->respondSuccess(null, 'Data was saved succesfully', 201);
    }
}
