<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitService = new UnitService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $units = $unitService->list($isPaginated, $perPage);
        return UnitResource::collection(
            $units
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UnitStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitStoreRequest $request)
    {
        $unitService = new UnitService();
        $unit = $unitService->store($request->all());
        return (new UnitResource($unit))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $unitService = new UnitService();
        $unit = $unitService->get($id);
        return new UnitResource($unit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UnitUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitUpdateRequest $request, int $id)
    {
        $unitService = new UnitService();
        $unit = $unitService->update($request->all(), $id);

        return (new UnitResource($unit))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $unitService = new UnitService();
        $unitService->delete($id);
        return response()->json([], 204);
    }
}
