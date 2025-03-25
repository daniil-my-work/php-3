<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function index(Request $request, string $id)
    {
        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request, string $id)
    {
        return response()->json([]);
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
