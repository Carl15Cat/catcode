<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddAutotestRequest;

use App\Models\Autotest;
use App\Models\Task;

class AutotestController extends Controller
{
    /**
     * Страница со списком автотестов
     */
    public function autotestlistView($taskId) {
        $task = Task::find($taskId);
        return view('teacher.autotestlist', compact('task'));
    }

    /**
     * Страница создания автотеста
     */
    public function addAutotestView($taskId) {
        $task = Task::find($taskId);
        return view('teacher.addAutotest', compact('task'));
    }

    /**
     * Создаёт автотест
     */
    public function addAutotest(AddAutotestRequest $request, $taskId) { 
        $data = $request->validated();

        $data['task_id'] = $taskId;

        Autotest::create($data);
        return redirect()->route('autotestlist', $taskId);
    }

    /**
     * Удаляет автотест
     */
    public function deleteAutotest($taskId, $autotestId) {
        Autotest::find($autotestId)->delete();

        return redirect()->route('autotestlist', $taskId);
    }
}
