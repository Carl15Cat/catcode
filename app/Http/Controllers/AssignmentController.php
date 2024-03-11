<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}