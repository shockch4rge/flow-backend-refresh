<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return ChecklistItem::all();
    }

    public function store(Request $request)
    {
        $checklistItem = new ChecklistItem();
        $checklistItem->checklist_id = $request->checklistId;
        $checklistItem->name = $request->name;
        $checklistItem->checked = false;
        $checklistItem->save();
    }

    public function show($id)
    {
        return ChecklistItem::find($id);
    }

    public function update(Request $request, $id)
    {
        $checklistItem = ChecklistItem::find($id);
        $checklistItem->update($request->all());
    }

    public function destroy($id)
    {
        ChecklistItem::destroy($id);
    }

    public function toggle(string $id)
    {
        $checklistItem = ChecklistItem::find($id);
        $checklistItem->checked = !$checklistItem->checked;
        $checklistItem->save();
    }
}
