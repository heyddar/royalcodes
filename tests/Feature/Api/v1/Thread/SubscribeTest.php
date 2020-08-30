<?php

namespace Tests\Feature\Api\v1\Thread;

use App\Channel;
use App\Notifications\NewReplySubmited;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    /**
     * @test
     */
    public function user_can_subscribe_to_a_channel()
    {
        Sanctum::actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create();

        $response = $this->post(route('subscribe',[$thread]));

        $response->assertSuccessful();

        $response->assertJson([
            'message' => 'user subscribed successfully'
        ]);

    }
    /**
     * @test
     */
    public function user_can_unsubscribe_from_a_channel()
    {
        Sanctum::actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->create();

        $response = $this->post(route('unsubscribe',[$thread]));

        $response->assertSuccessful();

        $response->assertJson([
            'message' => 'user unsubscribed successfully'
        ]);

    }

    /**
     * @test
     */
    public function notification_will_send_to_subscribers_of_a_thread()
    {
        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        Notification::fake();
        $thread  = factory(Thread::class)->create();
        $subscribe_response = $this->post(route('subscribe',[$thread]));

        $subscribe_response->assertSuccessful();

        $subscribe_response->assertJson([
            'message' => 'user subscribed successfully'
        ]);

        $answer_response = $this->postJson(route('answers.store'),[
            'content'   => 'foo',
            'thread_id' => $thread->id
        ]);
        $answer_response->assertSuccessful();
        $answer_response->assertJson([
            'message' => 'answer submitted successfully'
        ]);
        Notification::assertSentTo($user, newReplySubmited::class);
    }
}
