<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Comment::all();
    }

    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->author_id = $request->authorId;
        $comment->card_id = $request->cardId;
        $comment->content = $request->content;

        $comment->save();
    }

    public function show($id)
    {
        return Comment::find($id);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment = $comment->update($request->all());
        $comment->save();

        return $comment;
    }

    public function destroy($id)
    {
        Comment::destroy($id);
    }
}
