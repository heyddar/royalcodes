<?php

namespace Tests\Unit\Http\Controllers\Api\v01\Channel;

use App\Channel;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{

    /**
     * Test Indexing
     */
    public function test_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test Validation In Creating
     */
    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test Creating
     */
    public function test_channel_can_be_created()
    {
        $response = $this->postJson(route('channel.create'),[
            'name'  =>  'laravel'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test Channel Update
     */
    public function test_channel_update_should_be_validated()
    {
        $response = $this->Json('PUT',route('channel.update'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_channel_update()
    {
        $channel = factory(Channel::class)->create([
            'name' => 'laravel'
        ]);
        $response = $this->Json('PUT',route('channel.update'),[
            'id'   => $channel->id,
            'name' => 'vuejs'
        ]);
        $updatechannel = Channel::find($channel->id);
        $response ->assertStatus(Response::HTTP_OK);
        $this->assertEquals('vuejs',$updatechannel->name);
    }

    /**
     * Test Delete Channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $response = $this->Json('DELETE',route('channel.delete'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $channel = factory(Channel::class)->create();
        $response = $this->Json('DELETE',route('channel.delete'),[
           'id' => $channel->id
        ]);

        $response ->assertStatus(Response::HTTP_OK);
    }
}
