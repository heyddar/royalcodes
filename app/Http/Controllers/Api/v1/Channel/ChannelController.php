<?php

namespace App\Http\Controllers\Api\v1\Channel;

use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(resolve(ChannelRepository::class)->index(),\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * Create New Channel
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate([
            'name'  =>  'required'
        ]);

        //Insert Channel To Database
        resolve(ChannelRepository::class)->create($request);

        return response()->json([
            'message'   =>  "channel created successfully"
        ], Response::HTTP_CREATED);
    }

    /**
     * Update Channel
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
        $request->validate([
            'name'  =>  'required'
        ]);
        //Update Channel To Database
        resolve(ChannelRepository::class)->update($request);

        return response()->json([
            'message'   =>  'channel edited successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Delete  Channel(s)
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'id'  =>  'required'
        ]);
        //Delete Channel To Database
        resolve(ChannelRepository::class)->delete($request);

        return response()->json([
            'message'   => 'channel deleted successfully'
        ],Response::HTTP_OK);
    }

}
