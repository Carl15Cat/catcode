<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;

use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function register(RegisterRequest $request) {
        $requests = $request->validated();
        User::create($requests);

        if(Auth::attempt($requests)){
            $request->session()->regenerate();
            return redirect()->route('/');
        } else {
            return redirect()->route('login');
        }
    }

    public function login(LoginRequest $request) {
        $requests = $request->validated();
        if(Auth::attempt($requests)){
            $request->session()->regenerate();
            return redirect()->route('/');
        } else {
            return back()->withErrors(['login' => 'Неправильный логин или пароль']);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->regenerate();
        return redirect()->route('/');
    }

    public function myProfileView() {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function userlistView(Request $request) {
        $searchString = $request['search'];

        if(is_null($searchString) && $searchString != ''){
            $list = User::paginate(15)->withQueryString();
        } else {
            $list = User::where('firstname', 'LIKE', "%$searchString%")
                        ->orWhere('lastname', 'LIKE', "%$searchString%")
                        ->orWhere('patronymic', 'LIKE', "%$searchString%")
                        ->orWhere('login', 'LIKE', "%$searchString%")
                        ->paginate(15)->withQueryString();
        }

        return view('admin.userlist', compact('list', 'searchString'));
    }

    public function addUserView() {
        $roles = Role::get();
        return view('admin.add_user', compact('roles'));
    }

    public function addUser(AddUserRequest $request) {
        $requests = $request->validated();
        User::create($requests);

        return redirect()->route('userlist');
    }

    public function userView($id) {
        $user = User::find($id);
        return view('user.profile', compact('user'));
    }

    public function editMyProfileView() {
        $user = Auth::user();
        $roles = Role::get();
        return view('user.edit', compact('user', 'roles'));
    }

    public function editUserView($id) {
        $user = User::find($id);
        $roles = Role::get();
        return view('user.edit', compact('user', 'roles'));
    }

    public function editUser(EditUserRequest $request, $id = null) {
        $requests = $request->validated();

        if(is_null($id)) {
            $user = Auth::user();
        } else {
            $user = User::find($id);
        }

        $updateData = [];

        foreach($requests as $key => $value) {
            if ($key != 'password_repeat' && $value != '') {
                $updateData[$key] = $value;
            }
        }

        $user->update($updateData);

        if(is_null($id)) {
            return redirect()->route('myProfile');
        } else {
            return redirect()->route('user', $id);
        }
    }
}
