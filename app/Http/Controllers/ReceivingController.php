<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceivingStoreRequest;
use App\Http\Requests\ReceivingUpdateRequest;
use App\Http\Resources\ReceivingResource;
use App\Models\Receiving;
use App\Services\ReceivingService;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $receivingService = new ReceivingService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $receivings = $receivingService->list($isPaginated, $perPage);
        return ReceivingResource::collection(
            $receivings
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ReceivingStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceivingStoreRequest $request)
    {
        $receivingService = new ReceivingService();
        $data = $request->except('products');
        $products = $request->products;
        $receiving = $receivingService->store($data, $products);
        return (new ReceivingResource($receiving))
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
        $receivingService = new ReceivingService();
        $receiving = $receivingService->get($id);
        return new ReceivingResource($receiving);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReceivingUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReceivingUpdateRequest $request, int $id)
    {
        $receivingService = new ReceivingService();
        $data = $request->except('products');
        $products = $request->products;
        $receiving = $receivingService->update($data, $products, $id);

        return (new ReceivingResource($receiving))
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
        $receivingService = new ReceivingService();
        $receivingService->delete($id);
        return response()->json([], 204);
    }
}