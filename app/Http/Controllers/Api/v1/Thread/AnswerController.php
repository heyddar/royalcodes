<?php

namespace App\Http\Controllers\Api\v1\Thread;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends Controller
{

    public function index()
    {
        $answers = resolve(AnswerRepository::class)->getAllAnswers();
        return response()->json($answers, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Answer $answer)
    {
        //
    }

    public function destroy(Answer $answer)
    {
        //
    }
}
