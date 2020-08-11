<?php

namespace Tests\Feature\Api\v1\Thread;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnswerTest extends TestCase
{
   /**
    * @test
    */
   function can_get_all_answers_list()
   {
        $response = $this->get(route('answers.index'));

        $response->assertSuccessful();
   }
}
