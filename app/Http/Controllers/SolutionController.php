<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\RunAutotestsRequest;
use App\Http\Requests\SetGradeRequest;

use App\Models\Assignment;
use App\Models\Solution;
use App\Models\Executable;

class SolutionController extends Controller
{
    /**
     * Создаёт решение для одного пользователя
     */
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

    /**
     * Возвращает страницу решения от лица студента
     */
    public function solutionStudentView($solutionId) {
        $solution = Solution::find($solutionId);
        
        return view('student.solution', compact('solution'));
    }

    /**
     * Возвращает страницу решения от лица преподавателя
     */
    public function solutionTeacherView($solutionId) {
        $solution = Solution::find($solutionId);

        return view('teacher.solution', compact('solution'));
    }

    /**
     * Запуск автотестов. 
     * 
     * Вводные данные берутся из БД по id решения, выполняемый код - из запроса. 
     * Сохраняет в таблицу Executables токены запущенных автотестов
     * В случае повторного запуска автотестов того же решения, старые записи
     * из таблицы Executables удаляются
     */
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
                'stdin' => $autotest->input,
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

    /**
     * Проверка статуса автотестов
     * 
     * Берёт токены запущенных автотестов из таблицы Executables по id решения
     * Проверяет status.id, который приходит из judge0
     * Если все автотесты выполнены успешно (status.id = 3), устанавливает is_passed = true для данного решения
     */
    public function checkAutotestsStatus($solutionId) {
        $solution = Solution::find($solutionId);
        if($solution->user_id != Auth::user()->id
        && Auth::user()->role_id != 1
        && Auth::user()->role_id != 2) {
            http_response_code(403);
            $role = Auth::user()->role_id;
            return ["success" => "false", "message" => "Нет доступа к этому решению"];
        }

        $results = [];
        $compiler = new CompilerController;

        $isDone = true;
        $isSuccess = true;

        // Получение результатов автотестов по токенам
        foreach ($solution->executables()->get() as $executable) {
            $data = $compiler->getSubmission($executable->token);
            $data['stdout'] = mb_convert_encoding($data['stdout'], 'UTF-8', 'UTF-8');
            $results += [$executable->autotest_id => $data];

            if ($data['status']['id'] < 3) {
                $isDone = false; // Автотест в очереди или выполняется
            } else if ($data['status']['id'] > 3) {
                $isSuccess = false; // Выполнение автотеста завершилось с ошибкой
            }
        }

        $solution->update(['is_passed' => $isDone && $isSuccess && $solution->executables()->count() > 0 ]);

        return [
            "success" => "true",
            "message" => "Данные получены",
            "results" => $results,
            "is_passed" => $isDone && $isSuccess,
        ];
    }

    /**
     * Оценка решения
     */
    public function setGrade(SetGradeRequest $request, $solutionId) {
        Solution::find($solutionId)->update(['grade' => $request->validated()['grade']]);

        return back();
    }
}
