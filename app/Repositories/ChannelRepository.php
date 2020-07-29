<?php


namespace App\Repositories;


use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelRepository
{
    /**
     * @param Request $request
     */
    public function create(Request $request): void
    {
        Channel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
    }
}
