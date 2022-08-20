<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Board::all();
    }

    public function store(Request $request)
    {
        $board = new Board();

        $board->name = trim($request->name);
        $board->description = "No description";
        $board->author_id = $request->authorId;

        $board->save();
    }

    public function show(string $id)
    {
        $board = Board::find($id);
        $board->tags = $board->tags()->get() ?? [];
        return $board;
    }

    public function update(Request $request, string $id)
    {
        Board::where("id", $id)->update($request->all());
        return Board::find($id);
    }

    public function destroy(string $id)
    {
        Board::destroy($id);
    }

    public function getUserBoards(string $id)
    {
        $boards = Board::where("author_id", $id)
            ->orderBy("created_at", "asc")
            ->get()
            ->map(fn ($board) => $this->show($board->id));
        return $boards;
    }
}
