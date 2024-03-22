<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\GiveTaskRequest;

use App\Models\Task;
use App\Models\Variable_type;
use App\Models\Group;
use App\Models\ProgrammingLanguage;
use App\Models\Assignment;

class TaskController extends Controller
{
    /**
     * Возвращает страницу со списком заданий
     */
    public function taskListView(Request $request) {
        $searchQuery = $request['search']; //Строка поиска

        $list = Task::where('name', 'LIKE', "%$searchQuery%")->paginate(14)->withQueryString();
        return view('teacher.tasklist', compact('list', 'searchQuery'));
    }

    /**
     * Возвращает страницу со списком заданий данного пользователя (студента)
     */
    public function studentTasksView(Request $request) {
        $searchQuery = $request['search']; //Строка поиска

        if($searchQuery == '') {
            $list = Auth::user()->solutions()->paginate(14)->withQueryString();
        } else {
            $list = Auth::user()->solutions()->whereHas('assignment', function($query) use ($searchQuery) {
                $query->whereHas('task', function($query) use ($searchQuery) {
                    $query->where('name', 'LIKE', "%$searchQuery%");
                });
            })->paginate(14)->withQueryString();
        }
        
        return view('student.tasklist', compact('list', 'searchQuery'));
    }

    /**
     * Возвращает страницу задания
     */
    public function taskView($id) {
        $task = Task::find($id);
        return view('teacher.task', compact('task'));
    }

    /**
     * Возвращает страницу добавления задания
     */
    public function addTaskView() {
        $programmingLanguages = ProgrammingLanguage::getAll();
        return view('teacher.addTask', compact('programmingLanguages'));
    }

    /**
     * Добавляет задание
     */
    public function addTask(AddTaskRequest $request) {
        $requests = $request->validated();

        $data = [
            'name' => $requests['name'],
            'description' => $requests['description'],
            'user_id' => Auth::user()->id,
            'programming_language_id' => $requests['language_id'],
        ];

        $task = Task::create($data);

        return redirect()->route('task', $task->id);
    }

    /**
     * Возвращает страницу редактирования задания
     */
    public function editTaskView($id) {
        $task = Task::find($id);
        $var_types = Variable_type::get();
        $programmingLanguages = ProgrammingLanguage::getAll();
        return view('teacher.editTask', compact('task', 'var_types', 'programmingLanguages'));
    }

    /**
     * Изменяет выбранное задание
     */
    public function editTask(AddTaskRequest $request, $id) {
        $requests = $request->validated();

        $data = [
            'name' => $requests['name'],
            'description' => $requests['description'],
            'user_id' => Auth::user()->id,
            'programming_language_id' => $requests['language_id'],
        ];

        Task::find($id)->update($data);

        return redirect()->route('task', $id);
    }

    /**
     * Удаляет задание
     */
    public function deleteTask($id) {
        Task::find($id)->delete();

        return redirect()->route('tasklist');
    }

    /**
     * Возвращает страницу выдачи задания группе. Задание и группа на этом этапе уже выбраны
     */
    public function giveTaskView($taskId, $groupId) {
        $task = Task::find($taskId);
        $group = Group::find($groupId);
        $programmingLanguages = ProgrammingLanguage::getAll();

        return view('teacher.giveTask', compact('task', 'group', 'programmingLanguages'));
    }

    /**
     * Выдаёт задание группе
     */
    public function giveTask(GiveTaskRequest $request, $taskId, $groupId) {
        $requests = $request->validated();

        $deadline = $requests['deadline_date'].' '.$requests['deadline_time'];
        
        // Если срок сдачи уже наступил
        if($deadline < date('Y-m-d H:i:s')) {
            return back()->withErrors(['deadline' => 'Срок сдачи не должен быть уже наступившим']);
        }

        AssignmentController::createAssignment($taskId, $groupId, $deadline);
        
        return redirect()->route('task', $taskId);
    }

    /**
     * Отменяет данное группе задание
     */
    public function cancelTask($taskId, $groupId) {
        $assignment = Assignment::where('task_id', $taskId)->where('group_id', $groupId)->first();

        $assignment->delete();
        return redirect()->route('task', $taskId);
    }
}
