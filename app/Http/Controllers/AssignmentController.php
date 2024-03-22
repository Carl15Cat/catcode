<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GiveTaskRequest;

use App\Models\Assignment;
use App\Models\Group;

class AssignmentController extends Controller
{
    /**
     * Даёт задание группе
     */
    public static function createAssignment($taskId, $groupId, $deadline) {
        $data = [
            'task_id' => $taskId,
            'group_id' => $groupId,
            'deadline' => $deadline,
        ];

        $assignment = Assignment::create($data);

        foreach (Group::find($groupId)->users()->get() as $user) {
            $controller = new SolutionController;
            $controller->createSolution($assignment->id, $user->id);
        }

        return true;
    }

    /**
     * Возвращает страницу изменения дедлайна задания
     */
    public function editAssignmentView($assignmentId) {
        $assignment = Assignment::find($assignmentId);
        return view('teacher.editAssignment', compact('assignment'));
    }

    /**
     * Изменение дедлайна задания
     */
    public function editAssignment(GiveTaskRequest $request, $assignmentId) {
        $requests = $request->validated();

        $deadline = $requests['deadline_date'].' '.$requests['deadline_time'];

        // Если срок сдачи уже наступил
        if($deadline < date('Y-m-d H:i:s')) {
            return back()->withErrors(['deadline' => 'Срок сдачи не должен быть уже наступившим']);
        }

        $assignment = Assignment::find($assignmentId);
        $assignment->update(['deadline' => $deadline]);
        return redirect()->route('task', $assignment->task()->id);
    }
}