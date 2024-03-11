<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Assignment;
use App\Models\Solution;

class SolutionController extends Controller
{
    public function createSolution($assignmentId, $userId) {
        $assignment = Assignment::find($assignmentId);
        $language = $assignment->task()->programmingLanguage();

        $data = [
            'assignment_id' => $assignmentId,
            'user_id' => $userId,
            'code' => $language->default_code,
        ];

        Solution::create($data);

        return true;
    }
}
