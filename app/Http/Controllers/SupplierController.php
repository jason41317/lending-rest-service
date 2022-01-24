<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Http\Resources\SupplierResource;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $supplierService = new SupplierService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $suppliers = $supplierService->list($isPaginated, $perPage);
        return SupplierResource::collection(
            $suppliers
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SupplierStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierStoreRequest $request)
    {
        $supplierService = new SupplierService();
        $supplier = $supplierService->store($request->all());
        return (new SupplierResource($supplier))
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
        $supplierService = new SupplierService();
        $supplier = $supplierService->get($id);
        return new SupplierResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SupplierUpdateRequest;
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierUpdateRequest $request, int $id)
    {
        $supplierService = new SupplierService();
        $supplier = $supplierService->update($request->all(), $id);

        return (new SupplierResource($supplier))
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
        $supplierService = new SupplierService();
        $supplierService->delete($id);
        return response()->json([], 204);
    }
}
