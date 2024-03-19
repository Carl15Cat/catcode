<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\RunAutotestsRequest;

use App\Models\Assignment;
use App\Models\Solution;
use App\Models\Executable;

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

    public function solutionStudentView($solutionId) {
        $solution = Solution::find($solutionId);
        
        return view('student.solution', compact('solution'));
    }

    public function runAutotests(RunAutotestsRequest $request, $solutionId) {
        $solution = Solution::find($solutionId);
        if($solution->user_id != Auth::user()->id) {
            http_response_code(403);
            return ["success" => "false", "message" => "Данное решение не для этого пользователя"];
        }

        if($solution->task()->deadline > date('Y-m-d H:i:s')) {
            http_response_code(422);
            return ["success" => "false", "message" => "Задание просрочено"];
        }

        $requests = $request->validated();
        $solution->update(['code' => $requests['source_code']]); // Сохранение кода студента в БД

        // Удаление предыдущих executables
        foreach ($solution->executables()->get() as $exec) {
            $exec->delete();
        }

        // Создание запросов для выполнения кода на каждом автотесте
        foreach ($solution->task()->autotests()->get() as $autotest) {
            $compiler = new CompilerController;
            // Создание запроса
            $token = $compiler->createSubmission([
                'source_code' => trim($requests['source_code']),
                'language_id' => $solution->task()->programming_language_id,
                'stdin' => $autotest->stdin(),
                'expected_output' => $autotest->expected_output,
                // 'callback_url' => "172.17.0.1/api/setComplete/".$solutionId."/".$autotest->id, // Не получается достучаться из контейнера
            ]);

            // Сохранение токена
            $executable = Executable::create([
                'solution_id' => $solutionId,
                'autotest_id' => $autotest->id,
                'token' => $token,
            ]);
        }

        return ["success" => "true", "message" => "Создано"];
    }

    public function checkAutotestsStatus($solutionId) {
        $solution = Solution::find($solutionId);
        if($solution->user_id != Auth::user()->id) {
            http_response_code(403);
            return ["success" => "false", "message" => "Данное решение не для этого пользователя"];
        }

        $results = [];
        $compiler = new CompilerController;

        // Получение результатов автотестов по токенам
        foreach ($solution->executables()->get() as $executable) {
            $data = $compiler->getSubmission($executable->token);
            $results += [$executable->autotest_id => $data];
        }

        return [
            "success" => "true",
            "message" => "Данные получены",
            "results" => $results,
        ];
    }
}
