<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AddGroupRequest;

use App\Models\Group;

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

    public function addGroup(AddGroupRequest $request) {
        $requests = $request->validated();
        Group::create($requests);

        return redirect()->route('grouplist');
    }
}
