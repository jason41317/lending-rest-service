<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdjustmentStoreRequest;
use App\Http\Requests\AdjustmentUpdateRequest;
use App\Http\Resources\AdjustmentResource;
use App\Models\Adjustment;
use App\Services\AdjustmentService;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adjustmentService = new AdjustmentService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $adjustments = $adjustmentService->list($isPaginated, $perPage);
        return AdjustmentResource::collection(
            $adjustments
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdjustmentStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdjustmentStoreRequest $request)
    {
        $adjustmentService = new AdjustmentService();
        $data = $request->except('products');
        $products = $request->products;
        $adjustment = $adjustmentService->store($data, $products);
        return (new AdjustmentResource($adjustment))
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
        $adjustmentService = new AdjustmentService();
        $adjustment = $adjustmentService->get($id);
        return new AdjustmentResource($adjustment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdjustmentUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdjustmentUpdateRequest $request, int $id)
    {
        $adjustmentService = new AdjustmentService();
        $data = $request->except('products');
        $products = $request->products;
        $adjustment = $adjustmentService->update($data, $products, $id);

        return (new AdjustmentResource($adjustment))
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
        $adjustmentService = new AdjustmentService();
        $adjustmentService->delete($id);
        return response()->json([], 204);
    }
}
