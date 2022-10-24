<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    protected $collectionResource = 'App\Http\Resources\ActivitiesResource';
    protected $resource = 'App\Http\Resources\ActivityResource';

    /**
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function index(Request $request)
    {

        if ($request->has('search_date')) {
            $searchDate = $request->get('search_date');
            if (!empty($searchDate)) {
                $now = Carbon::now();
                Log::debug($now->format("Y-m-d"));
                Log::debug($searchDate);
                if ($now->format("Y-m-d") <= $searchDate) {
                    $activity = Activity::where("start_at", ">=", $searchDate)->orderBy("popularity", "desc")->limit(100)->get();
                    return new $this->collectionResource($activity);
                }
            }
        }
        return response()->json([], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $activity = Activity::with(['activities', 'activities.activity'])->find($id);
        if (!$activity) {
            return response()->json([
                'message' => __('entities.IDNotFound'),
                'error' => __('entities.IDNotFound'),
            ], 404);
        }
        return new $this->resource($activity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
