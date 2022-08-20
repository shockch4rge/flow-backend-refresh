<?php

namespace App\Http\Controllers;

use App\Models\Components\Checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Checklist::all();
    }

    public function store(Request $request)
    {
        $checklist = new Checklist();
        $checklist->card_id = $request->cardId;
        $checklist->content = $request->content;
        $checklist->items = [];
        $checklist->save();
    }

    public function show($id)
    {
        return response()->json([
            "status" => "error",
            "message" => "Not implemented",
        ]);
    }

    public function update(Request $request, $id)
    {
        $checklist = Checklist::find($id);
        $checklist->update($request->all());
    }

    public function destroy($id)
    {
        Checklist::destroy($id);
    }
}
