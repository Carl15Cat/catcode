<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddGroupRequest;
use App\Http\Requests\EditGroupRequest;

use App\Models\Group;
use App\Models\User;

class GroupController extends Controller
{
    /**
     * Возвращает страницу со списком групп
     */
    public function grouplistView(Request $request) {
        $searchString = $request['search']; // Строка поиска, пригодится позже

        $list = Group::paginate(15)->withQueryString();
        return view('teacher.grouplist', compact('list', 'searchString'));
    }

    /**
     * Возвращает страницу добавления группы
     */
    public function addGroupView() {
        return view('teacher.add_group');
    }

    /**
     * Добавляет новую группу
     */
    public function addGroup(AddGroupRequest $request) {
        $requests = $request->validated();
        Group::create($requests);

        return redirect()->route('grouplist');
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
     * Удаляет пользователя из группы
     */
    public function deleteUser($groupId, $userId) {
        $group = Group::find($groupId);
        $group->belongsToMany(User::class)->detach(User::find($userId));

        return view('teacher.group', compact('group'));
    }
}
