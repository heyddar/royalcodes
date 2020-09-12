<?php


namespace App\Repositories;


use App\Subscribe;


class SubscribeRepository
{
    public function getNotifiableUsers($thread_id)
    {
        return Subscribe::query()->where('thread_id',$thread_id)->pluck('user_id')->all();
    }
}
