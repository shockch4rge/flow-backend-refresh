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

        $board->name = $request->name;
        $board->description = "No description";
        $board->author_id = $request->authorId;

        $board->save();

        return response()->json([
            "status" => "success",
            "board" => $board,
        ]);
    }

    public function show(string $id)
    {
        return Board::find($id);
    }

    public function update(Request $request, string $id)
    {
        Board::where("id", $id)->update($request->all());
        return Board::find($id);
    }

    public function destroy(string $id)
    {
        Board::destroy($id);
        return response();
    }

    public function getUserBoards(string $id) {
        return Board::where("author_id", $id)->orderBy("created_at", "asc")->get();
    }
}
