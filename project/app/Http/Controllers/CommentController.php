<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function index(Request $request, string $id)
    {
        $film = Film::with('comments')->findOrFail($id);

        $filterComments = array_map(function ($comment) {
            return [
                'text' => $comment['text'],
                'rating' => $comment['rating'],
                'author' => $comment['author'],
            ];
        }, $film->comments->toArray());

        return $this->success([
            'comments' => $filterComments
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'text' => ['required', 'string', 'min:50'],
            'rating' => ['required', 'int', 'min:1', 'max:9'],
            'comment_id' => ['int'],
            'film_id' => ['int'],
        ]);

        $film = Film::find($id);

        $comment = Comment::create([
            'text' => $validatedData['text'],
            'rating' => $validatedData['rating'],
            'comment_id' => $validatedData['comment_id'],
            'film_id' => $film->id,
        ]);

        $film->fresh('comments');
        return $this->success([
            'message' => "Успешно добавлен комментарий ID = {$comment->id}",
            'film' => $film->comments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            abort(404, 'Комментарий не найден');
        }

        if (!Gate::allows('edit-comment', $comment)) {
            abort(403, 'Комментарий может редактировать только модератор или сам пользователь');
        }

        $validatedData = $request->validate([
            'text' => 'string',
        ]);

        $comment->fill($validatedData);
        $comment->save();

        return $this->success(['message' => "Комментарий {$id} успешно отредактирован"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->id);
        if (!Gate::allows('delete-comment')) {
            abort(403, 'Комментарий может удалить только модератор.');
        }

        if (!$comment) {
            abort(404, 'Комментарий не найден');
        }

        $comment->delete();
        return $this->success(['message' => "Комментарий {$comment->id} успешно удален"], 200);
    }
}
