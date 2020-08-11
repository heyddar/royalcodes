<?php


namespace App\Repositories;


use App\Answer;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnswerRepository
{
    /**
     * Index Answers
     * @return mixed
     */
    public function getAllAnswers()
    {
        return Answer::query()->latest()->get();
    }

}
