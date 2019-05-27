<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Api\V1\Requests\BrandStore;
use App\Api\V1\Requests\BrandUpdate;

class BrandController extends Controller
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
        $with = $request->input('with', '');
        $query = Brand::query();
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
    public function store(BrandStore $request)
    {
        $brand = $request->all();
        $brand = Brand::create($brand);
        return response()->json([
            'status' => 200,
            'data' => $brand,
            'message' => 'Successfully created.'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Brand $brand)
    {
        $with = $request->input('with', '');
        if ($with) {
            $with = explode(',', $with);
            $brand->load($with);
        }
        return response()->json([
            'status' => 200,
            'data' => $brand
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
    public function update(BrandUpdate $request, Brand $brand)
    {
        $request = $request->all();
        $brand->update($request);
        return response()->json([
            'status' => 200,
            'data' => $brand,
            'message' => 'Successfully updated.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully deleted.'
        ], 200);
    }
}
