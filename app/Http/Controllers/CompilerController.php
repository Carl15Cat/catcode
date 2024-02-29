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

    public function freeCompilerView() {
        $programmingLanguages = ProgrammingLanguage::getAll();
        return view('compiler.compiler', compact('programmingLanguages'));
    }

    public function runFreeCompiler(FreeCompilerRequest $request) {
        $data = $request->validated();

        if(!ProgrammingLanguage::find($data['language_id'])){
            return response()->json(['message' => 'Invalid language_id'], 422);
        }

        // Запрос к judge0
        $response = Http::post($this->judge_url."/submissions", $data);

        if($response->successful()) {
            return response()->json($response->json(), 201);
        } else {
            return response()->json(['message' => 'Unknown error'], 500);
        }
    }

    public function __construct() {
        $this->judge_url = config('judge.url');
    }
}
