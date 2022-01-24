<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderStoreRequest;
use App\Http\Requests\PurchaseOrderUpdateRequest;
use App\Http\Resources\PurchaseOrderResource;
use App\Services\PurchaseOrderService;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchaseOrderService = new PurchaseOrderService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $purchaseOrders = $purchaseOrderService->list($isPaginated, $perPage);
        return PurchaseOrderResource::collection(
            $purchaseOrders
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PurchaseOrderStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderStoreRequest $request)
    {
        $purchaseOrderService = new PurchaseOrderService();
        $data = $request->except('products');
        $products = $request->products;
        $purchaseOrder = $purchaseOrderService->store($data, $products);
        return (new PurchaseOrderResource($purchaseOrder))
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
        $purchaseOrderService = new PurchaseOrderService();
        $purchaseOrder = $purchaseOrderService->get($id);
        return new PurchaseOrderResource($purchaseOrder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PurchaseOrderUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderUpdateRequest $request, int $id)
    {
        $purchaseOrderService = new PurchaseOrderService();
        $data = $request->except('products');
        $products = $request->products;
        $purchaseOrder = $purchaseOrderService->update($data, $products, $id);

        return (new PurchaseOrderResource($purchaseOrder))
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
        $purchaseOrderService = new PurchaseOrderService();
        $purchaseOrderService->delete($id);
        return response()->json([], 204);
    }
}
