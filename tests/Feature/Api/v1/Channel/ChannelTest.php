<?php

namespace Tests\Feature\Api\v1\Channel;

use App\Channel;
use App\User;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    public function registerRolesAndPermissions()
    {
        $roleInDatabase = \Spatie\Permission\Models\Role::where('name', config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1){
            foreach (config('permission.default_roles') as $role) {
                \Spatie\Permission\Models\Role::create([
                    'name' => $role
                ]);
            }
        }
        $permissionInDatabase = \Spatie\Permission\Models\Permission::where('name', config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1){
            foreach (config('permission.default_permissions') as $permission){
                \Spatie\Permission\Models\Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }

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
        $this->registerRolesAndPermissions();

        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $user->givePermissionTo('channel management');

        $response = $this->postJson(route('channel.create'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test Creating
     */
    public function test_channel_can_be_created()
    {
        $this->registerRolesAndPermissions();

        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $user->givePermissionTo('channel management');

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
        $this->registerRolesAndPermissions();

        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $user->givePermissionTo('channel management');

        $response = $this->Json('PUT',route('channel.update'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_channel_update()
    {
        $this->registerRolesAndPermissions();

        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $user->givePermissionTo('channel management');

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
        $this->registerRolesAndPermissions();

        $user = factory(User::class)->create();
        Sanctum::actingAs($user);

        $user->givePermissionTo('channel management');

        $response = $this->Json('DELETE',route('channel.delete'));

        $response ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $this->registerRolesAndPermissions();

        $user = factory(User::class)->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');

        $channel = factory(Channel::class)->create();
        $response = $this->Json('DELETE',route('channel.delete'),[
           'id' => $channel->id
        ]);

        $response ->assertStatus(Response::HTTP_OK);
    }
}
