<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Card::all();
    }

    public function store(Request $request)
    {
        // create a card with default values
        $card = new Card();
        $card->name = $request->name;
        $card->description = "No description";
        // folder index depends on the number of cards in the folder
        $card->folder_index = Card::where('folder_id', $request->folderId)->count();
        $card->folder_id = $request->folderId;
        $card->save();
    }

    public function show(string $id)
    {
        $card = Card::find($id);

        $card->comments = $card->comments()->get();
        $card->checklists = $card->checklists()->get()->map(fn($checklist) => [
            "id" => $checklist->id,
            "name" => $checklist->name,
            "description" => $checklist->description,
            "items" => $checklist->items()->get(),
        ]);
        $card->tags = $card->tags()->get();
        $card->notepads = $card->notepads()->get();

        return $card;
    }

    public function update(Request $request, $id)
    {
        Card::where("id", $id)->update($request->all());
        return Card::find($id);
    }

    public function destroy($id)
    {
        Card::destroy($id);
    }

    public function getFolderCards(string $id)
    {
        // order cards by folder index
        return Card::where("folder_id", $id)->orderBy("folder_index", "asc")->get();
    }

    public function move(Request $request, string $id)
    {
        /* card index could be:
            at the beginning of the folder
            at the end of the folder
            somewhere in the middle of the folder
        */
        $card = Card::find($id);
        $folderLength = Card::where('folder_id', $request->folderId)->count();
  
        $card->folder_id = $request->folderId;

        // if the folder has no items, set the card index to be the first item
        if ($folderLength <= 0) {
            $card->folder_index = 0;  
        }
        // if the card is start of the list, increment all cards' indexes after
        else if ($request->index == 0) {
            Card::where("folder_id", $request->folderId)->increment("folder_index");
        }
        // if the drop index is larger than the target folder's length, limit the index to it
        else if ($request->index > $folderLength) {
            $card->folder_index = $folderLength;
        }
        // if the card is placed in the middle of the list, increment all other cards' indexes after the card's index
        else if ($request->index > 0 && $request->index < $folderLength) {
            Card::where("folder_id", $request->folderId)
                ->where("folder_index", ">=", $request->index)
                ->increment("folder_index");
            // then we save the index
            $card->folder_index = $request->index;
        }

        $card->save();
    }
}
