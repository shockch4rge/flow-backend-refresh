<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return Tag::all();
    }

    public function store(Request $request)
    {
        $tag = new Tag();
        $tag->board_id = $request->boardId;
        $tag->content = $request->content;
        $tag->color_code = $request->colorCode;

        $tag->save();
    }

    public function show($id)
    {
        return Tag::find($id);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            "status" => "error",
            "message" => "Updating tags is not implemented!"
        ]);
    }

    public function destroy($id)
    {
        Tag::destroy($id);
    }
}
