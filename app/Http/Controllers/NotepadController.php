<?php

namespace App\Http\Controllers;

use App\Models\Components\Notepad;
use Illuminate\Http\Request;

class NotepadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Notepad::all();
    }

    public function store(Request $request)
    {
        $notepad = new Notepad();
        $notepad->card_id = $request->cardId;
        $notepad->content = $request->content;

        error_log($notepad);
        $notepad->save();
    }

    public function show($id)
    {
        return Notepad::find($id);
    }

    public function update(Request $request, $id)
    {
        $notepad = Notepad::find($id);
        $notepad->update($request->all());
    }

    public function destroy($id)
    {
        Notepad::destroy($id);
    }
}
