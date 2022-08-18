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
        Folder::destroy($id);
    }

    public function getBoardFolders(string $id)
    {
        return Folder::where("board_id", $id)->orderBy("board_index", "asc")->get();
    }

    public function move(Request $request) 
    {
        $folder = Folder::find($request->folderId);
        $boardLength = Folder::where('board_id', $request->boardId)->count();

        if ($request->index >= $boardLength) {
            $folder->board_index = $boardLength;
        } else {
            $folder->board_index = $request->index;
        }

        $folder->save();
    }
}
