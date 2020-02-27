<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        $users = User::where('role', '=', 'user')
            ->orderBy('id', 'desc')
            ->paginate( 6 );

        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $users = User::find($id);
        return view('users.show', compact('users'));
    }

    public function edit($id)
    {
        $users = User::find($id);
        return view('users.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        if ($request['approved']) {
            $request['approved_at'] = now();
        }

        User::find($id)->update($request->all());

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('users.index');
    }
}
