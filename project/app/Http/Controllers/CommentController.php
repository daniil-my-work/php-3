<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

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
        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment = Comment::find($comment);
        $comment->delete($comment->id);
        return $this->success(['message' => "Комментарий $comment->id успешно удален", 200]);
    }
}
