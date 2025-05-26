<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
class MovieController extends Controller
{
    public function show($id)
    {
        // Logic to retrieve movie details by ID
        $movie = Movie::findorFail($id);
        return response()->json($movie);
    }
}
