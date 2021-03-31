<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:170',
            'username' => 'required|string|max:170',
            'password' => 'required|confirmed|max:32',
        ]);

        $u = new User;
        $u->name = $request->name;
        $u->username = $request->username;
        $u->password = bcrypt($request->password);
        $u->role = 'user';
        $u->save();

        $this->message('success', 'User created successfully');
        return redirect()->route('users');
    }

    public function edit($uid)
    {
        $user = User::find($uid);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:170',
            'username' => 'required|string|max:170',
            'password' => 'confirmed|max:32',
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->username = $request->username;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $this->message('success', 'User updated successfully');
        return redirect()->route('users');
    }

    public function destroy($uid)
    {
        $user = User::find($uid);
        if ($user->course_types->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->courses->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->mentors->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->institutes->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->batches->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->students->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->accounts->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->payments->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->teachers->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } else {
            $user->delete();
            $this->message('success', 'User deleted successfully');
            return redirect()->route('users');
        }
    }

    public function isAdmin()
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('home');
        }
    }
}
