<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class AlbumController extends Controller
{
    public function index($id = "")
    {
        if (!$id) {
            return "error";
        }
        return response()->json([
            "message" => "andi"
        ], 200);
    }
}
