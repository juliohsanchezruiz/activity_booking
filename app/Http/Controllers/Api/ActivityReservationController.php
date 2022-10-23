<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityReservationRequest;
use App\Models\Activity;
use App\Models\ActivityReservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ActivityReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = ActivityReservation::with("activity");
        return DataTables::of($data)->make(true);
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
    public function store($id, ActivityReservationRequest $request)
    {
        //
        $activity = Activity::find($id);
        try {
            $activityReservation = new ActivityReservation;
            $activityReservation->activity_id = $activity->id;
            $activityReservation->number_people = $request->number_people;
            $activityReservation->total_price = $request->number_people * $activity->price_person;
            $activityReservation->activity_date = $activity->start_at;
            $activityReservation->relationship_date = Carbon::now()->format('Y-m-d');
            $activityReservation->save();
            return response()->json(["message" => "Seguardo el registro correctamente"], 201);
        } catch (\Exception $exception) {
            return response()->json(["message" => "No se pudo guardar el registro"], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ActivityReservation $activityReservation
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityReservation $activityReservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ActivityReservation $activityReservation
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityReservation $activityReservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ActivityReservation $activityReservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityReservation $activityReservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ActivityReservation $activityReservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityReservation $activityReservation)
    {
        //
    }
}
