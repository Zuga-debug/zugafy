<?php
// app/Http/Controllers/WatchlistController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Watchlist;

class WatchlistController extends Controller
{
    public function index()
    {
        return Watchlist::all();
    }

    public function show($tmdb_id)
    {
        $exists = Watchlist::where('tmdb_id', $tmdb_id)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function store(Request $request, $tmdb_id)
    {
        $exists = Watchlist::where('tmdb_id', $tmdb_id)->first();
        if (!$exists) {
            Watchlist::create([
                'tmdb_id' => $tmdb_id,
                'title' => $request->title,
                'poster_path' => $request->poster_path,
            ]);
        }
        return response()->json(['status' => 'added']);
    }

    public function destroy($tmdb_id)
    {
        Watchlist::where('tmdb_id', $tmdb_id)->delete();
        return response()->json(['status' => 'removed']);
    }
}
