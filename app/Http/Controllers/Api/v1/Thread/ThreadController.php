<?php

namespace App\Http\Controllers\Api\v1\Thread;

use App\Thread;
use App\Http\Controllers\Controller;
use App\Repositories\ThreadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user-block'])->except([
            'index',
            'show'
        ]);
    }

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
        if(Gate::forUser(auth()->user())->allows('user-thread', $thread)){
            resolve(ThreadRepository::class)->update($request,$thread);
            return response()->json([
                'message'   =>  'thread edited successfully'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message'   =>  'access denied'
        ], Response::HTTP_FORBIDDEN);

    }


    public function destroy(Thread $thread)
    {
        if(Gate::forUser(auth()->user())->allows('user-thread', $thread)){
            resolve(ThreadRepository::class)->destroy($thread);
            return response()->json([
                'message'   =>  'thread deleted successfully'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message'   =>  'access denied'
        ], Response::HTTP_FORBIDDEN);


    }
}
