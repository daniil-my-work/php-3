<?php

namespace App\Http\Controllers;

use App\Jobs\SaveFilmJob;
use App\Jobs\TestSaveFilmJob;
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
        $validatedData = $request->validate([
            'imdb_id' => ['required', 'string', 'min:1']
        ]);

        // Создает задачу на добавления фильма
        // SaveFilmJob::dispatch($validatedData['imdb_id']);
        TestSaveFilmJob::dispatch($validatedData['imdb_id']);

        return $this->success([
            'message' => "Добавлена задача на сохранение фильма с ID={$validatedData['imdb_id']}.",
        ]);
    }

    public function show(Request $request, string $id)
    {
        $film = Film::findOrFail($id);

        return $this->success([
            'film' => $film
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'poster_image' => ['string', 'max:255'],
            'preview_image' => ['string', 'max:255'],
            'background_image' => ['string', 'max:255'],
            'background_color' => ['string', 'max:9'],
        ]);

        $film = Film::findOrFail($id);
        $film->update($validatedData);

        return $this->success([
            'message' => 'Фильм успешно обновлен.',
            'updated_film' => $film
        ]);
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
