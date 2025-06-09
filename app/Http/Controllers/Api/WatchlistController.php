<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Watchlist;

class WatchlistController extends Controller
{
    public function index(Request $request)
    {
        $watchlist = Watchlist::where('user_id', $request->user()->id)->get();
        return response()->json($watchlist);
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required',
            'title' => 'required',
            'poster_path' => 'nullable',
        ]);

        $watchlist = Watchlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'movie_id' => $request->movie_id,
        ], [
            'title' => $request->title,
            'poster_path' => $request->poster_path,
        ]);

        return response()->json($watchlist, 201);
    }

    public function destroy(Request $request, $movie_id)
    {
        Watchlist::where('user_id', $request->user()->id)
            ->where('movie_id', $movie_id)
            ->delete();

        return response()->json(['message' => 'Removed from watchlist']);
    }
}
