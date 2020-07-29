<?php

namespace Tests\Unit\Http\Controllers\Api\v01\Channel;

use Tests\TestCase;

class ChannelControllerTest extends TestCase
{

    /**
     * Test Indexing
     */
    public function test_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.index'));
        $response->assertStatus(200);
    }

    /**
     * Test Validation In Creating
     */
    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'));

        $response ->assertStatus(422);
    }

    /**
     * Test Creating
     */
    public function test_channel_can_be_created()
    {
        $response = $this->postJson(route('channel.create'),[
            'name'  =>  'laravel'
        ]);

        $response->assertStatus(201);
    }
}
