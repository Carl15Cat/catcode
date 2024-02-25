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
    /**
     * Возвращает страницу регистрации
     */
    public function registerView() {
        return view('auth.register');
    }

    /**
     * Регистрирует нового пользователя и сразу аутентифицирует его
     */
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

    /**
     * Возвращает страницу входа
     */
    public function loginView() {
        return view('auth.login');
    }

    /**
     * Аутентифицирует пользователя
     */
    public function login(LoginRequest $request) {
        $requests = $request->validated();

        if(Auth::attempt($requests)){
            $request->session()->regenerate();
            return redirect()->route('/');
        } else {
            return back()->withErrors(['login' => 'Неправильный логин или пароль']);
        }
    }

    /**
     * Выход из аккаунта
     */
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->regenerate();
        
        return redirect()->route('/');
    }

    /**
     * Возвращает страницу профиля текущего пользователя
     */
    public function myProfileView() {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    /**
     * Возвращает страницу добавления пользователя
     */
    public function addUserView() {
        $roles = Role::get();

        return view('admin.addUser', compact('roles'));
    }

    /**
     * Добавляет пользователя
     */
    public function addUser(AddUserRequest $request) {
        $requests = $request->validated();
        User::create($requests);

        return redirect()->route('userlist');
    }

    /**
     * Возвращает страницу редактирования профиля текущего пользователя
     */
    public function editMyProfileView() {
        $user = Auth::user();
        $roles = Role::get();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Возвращает страницу со списком всех пользователей
     */
    public function userlistView(Request $request) {
        $searchQuery = $request['search'];

        $list = User::search($searchQuery)->paginate(14)->withQueryString();

        return view('admin.userlist', compact('list', 'searchQuery'));
    }

    /**
     * Возвращает страницу профиля указанного пользователя
     */
    public function userView($id) {
        $user = User::find($id);

        return view('user.profile', compact('user'));
    }

    /**
     * Возвращает страницу редактирования профиля указанного пользователя
     */
    public function editUserView($id) {
        $user = User::find($id);
        $roles = Role::get();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Изменяет данные пользователя. Если id не был передан, изменяется текущий пользователь
     */
    public function editUser(EditUserRequest $request, $id = null) {
        $requests = $request->validated();

        // Если $id = null, редактируется текущий пользователь
        if(is_null($id)) {
            $user = Auth::user();
        } else {
            $user = User::find($id);
        }

        // Создание массива для обновлённых данных
        $updateData = [];

        // Заполнение массива
        foreach($requests as $key => $value) {
            // Пропуск пустых полей и поля повтора пароля
            if ($key == 'password_repeat' || $value == '') {
                continue;
            }

            // Пропуск поля с ролью пользователя, если пользователь - не администратор
            if (Auth::user()->role()->id != 1) {
                if($key == 'role_id') {
                    continue;
                }
            }

            // Заполнение массива
            $updateData[$key] = $value;
        }

        // Обновление данных
        $user->update($updateData);

        // Возврат в профиль
        if(is_null($id)) {
            return redirect()->route('myProfile');
        } else {
            return redirect()->route('user', $id);
        }
    }
}