<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();

        return $this->success([
            'genres' => $genres,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genre = Genre::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string|max:255',
        ]);

        $genre->update($validatedData);

        return $this->success([
            'message' => 'Жанр обновлен',
            'genre' => $genre,
        ], 200);
    }
}
