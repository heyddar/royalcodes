<?php


namespace App\Repositories;


use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ThreadRepository
{
    /**
     * Index Thread
     * @return mixed
     */
    public function getAllAvailableThreads()
    {
        return Thread::whereFlag(1)->latest()->get();
    }

    /**
     * Show Thread
     * @param $slug
     * @return mixed
     */
    public function getThreadBySlug($slug)
    {
        return Thread::whereSlug($slug)->whereFlag(1)->first();;
    }

    /**
     * Store Thread
     * @param Request $request
     */
    public function store(Request $request)
    {
        Thread::create([
            'title'         => $request->input('title'),
            'slug'          => Str::slug($request->input('title')) ,
            'content'       => $request->input('content'),
            'channel_id'    => $request->input('channel_id'),
            'user_id'       => auth()->user()->id,
        ]);
    }
    /**
     * Update Thread
     * @param Request $request
     */
    public function update(Request $request, Thread $thread): void
    {


        if (!$request->has('best_answer_id'))
        {
            $thread->update([
                'title'         => $request->input('title'),
                'slug'          => Str::slug($request->input('title')) ,
                'content'       => $request->input('content'),
                'channel_id'    => $request->input('channel_id'),
            ]);

        }else{
            $thread->update([
                'best_answer_id'    => $request->input('best_answer_id'),
            ]);
        }
    }

    /**
     * Destroy Thread
     * @param $id
     */
    public function destroy($id)
    {
        Thread::destroy($id);

    }
}
