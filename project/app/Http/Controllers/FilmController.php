<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'limit' => ['int'],
            'page' => ['int'],
            'genre' => ['string'],
            'status' => ['string'],
            'order_by' => ['string'],
            'order_to' => ['string'],
        ]);

        // Значения по умолчанию
        $limit = $data['limit'] ?? 8;
        $page = $data['page'] ?? 1;
        $genre = $data['genre'] ?? null;
        $status = $data['status'] ?? null;
        $order_by = $data['order_by'] ?? 'id';
        $order_to = $data['order_to'] ?? 'asc';

        $query = Film::query();

        if ($genre) {
            $query->whereHas('genres', function ($query) use ($genre) {
                $query->where('name', $genre);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $films = $query
            ->orderBy($order_by, $order_to)
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->get();

        return $this->success([
            'films' => $films,
            ...$data,
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([]);
    }

    public function show(Request $request, string $id)
    {
        $film = Film::findOrFail($id);

        return $this->success([
            'film' => $film
        ], 200);
    }

    public function update(Request $request)
    {


        return response()->json([]);
    }

    public function similar(Request $request, string $id)
    {
        $film = Film::with('genres')->findOrFail($id);

        if ($film->genres->isEmpty()) {
            return $this->success([
                'similar_films' => [],
            ]);
        }

        $genreName = $film->genres()->pluck('name');

        $films = Film::whereHas('genres', function ($query) use ($genreName) {
            $query->whereIn('name', $genreName);
        })
            ->where('id', '!=', $film->id)
            ->get();

        return $this->success([
            'similar_films' => $films,
        ]);
    }
}
