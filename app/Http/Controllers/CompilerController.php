<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ProgrammingLanguage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\FreeCompilerRequest;

class CompilerController extends Controller
{
    private $judge_url;

    /**
     * Возвращает страницу компилятора
     */
    public function freeCompilerView() {
        $programmingLanguages = ProgrammingLanguage::getAll();
        return view('compiler.compiler', compact('programmingLanguages'));
    }

    /**
     * Создаёт submission для свободного компилятора и возвращает клиенту его токен
     */
    public function runFreeCompiler(FreeCompilerRequest $request) {
        $data = $request->validated();

        if(!ProgrammingLanguage::find($data['language_id'])){
            return response()->json(['message' => 'Invalid language_id'], 422);
        }

        $response = $this->createSubmission($data);

        return is_null($response) ? response()->json(['message' => 'Unknown error'], 500) : response()->json(["token" => $response], 201);
    }

    /**
     * Создаёт submission 
     * 
     * $data - массив данных для запроса к judge0. См. Judge0 API Docs
     * Возвращает строку с токеном созданного submission или null в случае ошибки
     */
    public function createSubmission($data) {
        $response = Http::post($this->judge_url."/submissions", $data); // Запрос к judge0

        if($response->successful()) {
            return $response->json()['token'];
        } else {
            return null;
        }
    }

    /**
     * Возвращает данные о submission из judge0
     */
    public function getSubmission($token) {
        $response = Http::get($this->judge_url."/submissions/".$token); // Запрос к judge0

        if($response->successful()) {
            return $response->json();
        } else {
            return null;
        }
    }

    public function __construct() {
        $this->judge_url = config('judge.url');
    }
}
