<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Api\V1\Requests\VehicleStore;
use App\Api\V1\Requests\VehicleUpdate;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 25);
        $keyword = $request->input('keyword', null);
        $sortBy = $request->input('sort_by', 'id');
        $orderBy = $request->input('order_by', 'asc');
        $searchBy = $request->input('search_by', 'name');
        $brandId = $request->input('brand_id', null);
        $with = $request->input('with', '');
        $query = Vehicle::query();
        $query->when($brandId, function ($q) use ($brandId) {
            return $q->where('brand_id', $brandId);
        });
        $query->when($keyword, function ($q) use ($searchBy, $keyword) {
            return $q->where($searchBy, 'like', '%'.$keyword.'%');
        });
        $data = $query->orderBy($sortBy, $orderBy)->paginate($perPage);
        if ($with) {
            $with = explode(',', $with);
            $data->load($with);
        }
        return response()->json([
            'status' => 200,
            'data' => $data
        ], 200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleStore $request)
    {
        $vehicle = $request->all();
        $vehicle = Vehicle::create($vehicle);
        return response()->json([
            'status' => 200,
            'data' => $vehicle,
            'message' => 'Successfully created.'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Vehicle $vehicle)
    {
        $with = $request->input('with', '');
        if ($with) {
            $with = explode(',', $with);
            $vehicle->load($with);
        }
        return response()->json([
            'status' => 200,
            'data' => $vehicle
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleUpdate $request, Vehicle $vehicle)
    {
        $request = $request->all();
        $vehicle->update($request);
        return response()->json([
            'status' => 200,
            'data' => $vehicle,
            'message' => 'Successfully updated.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted.'
        ], 200);
    }
}
