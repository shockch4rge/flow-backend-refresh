<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Folder::all();
    }

    public function store(Request $request)
    {
        $folder = new Folder();
        $folder->name = $request->name;
        $folder->board_id = $request->boardId;
        $folder->board_index = Folder::where('board_id', $request->boardId)->count();

        $folder->save();
    }

    public function show($id)
    {
        return Folder::find($id);
    }

    public function update(Request $request, $id)
    {
        Folder::where("id", $id)->update($request->all());
        return Folder::find($id);
    }

    public function destroy($id)
    {
        $folder = Folder::find($id);
        $boardCount = Folder::where('board_id', $folder->board_id)->count();

        if ($folder->board_index == 0) {
            $folder->delete();
            Folder::where("board_id", $folder->board_id)
                ->decrement("board_index");
        } else if ($folder->board_index > 0 && $folder->board_index < $boardCount) {
            $folder->delete();
            Folder::where("board_id", $folder->board_id)
                ->where("board_index", ">", $folder->board_index)
                ->decrement("board_index");
        } else {
            $folder->delete();
        }
    }

    public function getBoardFolders(string $id)
    {
        return Folder::where("board_id", $id)->orderBy("board_index", "asc")->get();
    }

    public function move(Request $request, string $id)
    {
        $folder = Folder::find($id);
        $boardLength = Folder::where('board_id', $request->boardId)->count();

        if ($request->index == 0) {
            $folder->board_index = 0;
            Folder::where("board_id", $request->boardId)
                ->increment("board_index");
        } else if ($request->index == $boardLength) {
            $folder->board_index = $boardLength;
        } else {
            $folder->board_index = $request->index;
            Folder::where("board_id", $request->boardId)
                ->where("board_index", ">", $request->index)
                ->increment("board_index");
        }

        $folder->save();
    }
}
