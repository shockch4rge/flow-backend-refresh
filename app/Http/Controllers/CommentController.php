<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Components\Comment;

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

    public function getCardComments(string $id) {
        return Comment::where("card_id", $id)->get();
    }
}
