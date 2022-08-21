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

        $card->comments = $card->comments()->orderBy('created_at', 'asc')->get();
        $card->checklists = $card->checklists()->get()->map(fn ($checklist) => [
            "id" => $checklist->id,
            "name" => $checklist->name,
            "description" => $checklist->description,
            "items" => $checklist->items()->get(),
        ]) ?? [];
        $card->tags = $card->tags()->get() ?? [];
        $card->notepads = $card->notepads()->get() ?? [];

        return $card;
    }

    public function update(Request $request, $id)
    {
        Card::where("id", $id)->update($request->all());
        return Card::find($id);
    }

    public function destroy($id)
    {
        // deleting a card can be at the start, middle or end of a folder
        $card = Card::find($id);
        $folderCount = Card::where('folder_id', $card->folder_id)->count();

        if ($card->folder_index === 0) {
            $card->delete();
            Card::where("folder_id", $card->folder_id)
                ->decrement("folder_index");
        } else if ($card->folder_index > 0 && $card->folder_index < $folderCount) {
            $card->delete();
            Card::where("folder_id", $card->folder_id)
                ->where("folder_index", ">", $card->folder_index)
                ->decrement("folder_index");
        } else {
            $card->delete();
        }
    }

    public function getFolderCards(string $id)
    {
        $cards = Card::where("folder_id", $id)
            ->orderBy("folder_index", "asc")
            ->get()
            ->map(fn ($card) => $this->show($card->id));
        return $cards;
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

        // if the folder has no items, set the card index to be the first item
        if ($folderLength <= 0) {
            $card->folder_index = 0;
        }
        // if the card is start of the list, increment all cards' indexes after
        else if ($request->index == 0) {
            $card->folder_index = 0;
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

        $card->folder_id = $request->folderId;

        $card->save();
    }

    public function assignTags(Request $request, string $id)
    {
        $card = Card::find($id);
        $card->tags()->sync($request->tagIds);

        $card->save();
    }
}
