<?php

namespace App\Http\Controllers\Api\v1\Thread;

use App\Repositories\ChannelRepository;
use App\Thread;
use App\Http\Controllers\Controller;
use App\Repositories\ThreadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ThreadController extends Controller
{

    /**
     * Index Thread
     * @return JsonResponse
     */
    public function index()
    {
        $threads = resolve(ThreadRepository::class)->getAllAvailableThreads();

            return response()->json($threads , Response::HTTP_OK);
    }

    /**
     * Show Thread
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug)
    {
        $thread = resolve(ThreadRepository::class)->getThreadBySlug($slug);

        return response()->json($thread , Response::HTTP_OK);
    }

    /**
     * Store Thread
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'content'       => 'required',
            'channel_id'    => 'required',
        ]);

        resolve(ThreadRepository::class)->store($request);

        return response()->json([
            'message' => 'thread created successfully'
        ], Response::HTTP_CREATED);
    }
    /**
     * Update Thread
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, Thread $thread)
    {
        $request->has('best_answer_id')
            ?
            $request->validate([
                'best_answer_id'         => 'required',
            ])
        :$request->validate([
            'title'         => 'required',
            'content'       => 'required',
            'channel_id'    => 'required',
            ]);
        //Update Thread To Database
        resolve(ThreadRepository::class)->update($request,$thread);

        return response()->json([
            'message'   =>  'thread edited successfully'
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * Destroy Thread
     * @param $id
     */
    public function destroy($id)
    {
        resolve(ThreadRepository::class)->destroy($id);

        return response()->json([
            'message'   =>  'thread deleted successfully'
        ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }
}
