<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): Collection
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
    }

    public function show(string $id)
    {
        return User::find($id);
    }

    public function update(Request $request, string $id)
    {
        User::where("id", $id)->update([
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
        ]);

        return User::find($id);
    }

    public function destroy(string $id)
    {
        User::destroy($id);
        return response();
    }
}
