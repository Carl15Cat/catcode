<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddGroupRequest;
use App\Http\Requests\EditGroupRequest;
use App\Http\Requests\AddUserToGroupRequest;

use App\Models\Group;
use App\Models\User;
use App\Models\Task;

class GroupController extends Controller
{
    /**
     * Возвращает страницу со списком групп
     */
    public function grouplistView(Request $request) {
        $searchQuery = $request['search']; // Строка поиска

        $list = Group::where('name', 'LIKE', $searchQuery)->paginate(15)->withQueryString();
        return view('teacher.grouplist', compact('list', 'searchQuery'));
    }

    /**
     * Возвращает страницу добавления группы
     */
    public function addGroupView() {
        return view('teacher.addGroup');
    }

    /**
     * Добавляет новую группу
     */
    public function addGroup(AddGroupRequest $request) {
        $requests = $request->validated();
        $group = Group::create($requests);

        return redirect()->route('group', $group->id);
    }

    /**
     * Возвращает страницу с информацией о группе
     */
    public function groupView($id) {
        $group = Group::find($id);

        return view('teacher.group', compact('group'));
    }

    /**
     * Изменяет информацию о группе (название)
     */
    public function editGroup(EditGroupRequest $request, $id) {
        $requests = $request->validated();
        Group::find($id)->update($requests);

        return back();
    }

    /**
     * Удаляет группу
     */
    public function deleteGroup($id) {
        Group::find($id)->delete();

        return redirect()->route('grouplist');
    }

    /**
     * Страница добавления пользователей в группу
     */
    public function addUsersView(Request $request, $groupId) {
        $searchQuery = $request['search']; // Строка поиска

        $group = Group::find($groupId);

        $userIdArray = array_column($group->users()->get()->toArray(), 'id'); // Массив id пользователй, состоящих в группе
        $users = User::where('role_id', 3)->whereNotIn('id', $userIdArray)->search($searchQuery); // Выбор всех студентов, не состоящих в группе

        $list = $users->paginate(14)->withQueryString();

        return view('teacher.addUsersToGroup', compact('group', 'list', 'searchQuery'));
    }

    /**
     * Добавляет пользователя в группу
     */
    public function addUser($groupId, $userId) {
        Group::find($groupId)->users()->attach($userId);

        return back();
    }

    /**
     * Удаляет пользователя из группы
     */
    public function deleteUser($groupId, $userId) {
        $group = Group::find($groupId);
        $group->belongsToMany(User::class)->detach(User::find($userId));

        return back();
    }

    /**
     * Возвращает страницу, на которой пользователь выбирает группу, которой дать уже выбранное задание
     */
    public function searchToGiveView(Request $request, $taskId) {
        $searchQuery = $request['search']; // Строка поиска

        $groups = Task::find($taskId)->assignments()->pluck('group_id');
        $list = Group::whereNotIn('id', $groups)
        ->where('name', 'LIKE', $searchQuery)->paginate(15)->withQueryString();
        return view('teacher.searchGroupToGiveTask', compact('taskId', 'list', 'searchQuery'));
    }
}
