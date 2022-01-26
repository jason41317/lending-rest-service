<?php

namespace App\Http\Controllers;

use App\Http\Requests\IssuanceStoreRequest;
use App\Http\Requests\IssuanceUpdateRequest;
use App\Http\Resources\IssuanceResource;
use App\Models\Issuance;
use App\Services\IssuanceService;
use Illuminate\Http\Request;

class IssuanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $issuanceService = new IssuanceService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $issuances = $issuanceService->list($isPaginated, $perPage);
        return IssuanceResource::collection(
            $issuances
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\IssuanceStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IssuanceStoreRequest $request)
    {
        $issuanceService = new IssuanceService();
        $data = $request->except('products');
        $products = $request->products;
        $issuance = $issuanceService->store($data, $products);
        return (new IssuanceResource($issuance))
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
        $issuanceService = new IssuanceService();
        $issuance = $issuanceService->get($id);
        return new IssuanceResource($issuance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\IssuanceUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(IssuanceUpdateRequest $request, int $id)
    {
        $issuanceService = new IssuanceService();
        $data = $request->except('products');
        $products = $request->products;
        $issuance = $issuanceService->update($data, $products, $id);

        return (new IssuanceResource($issuance))
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
        $issuanceService = new IssuanceService();
        $issuanceService->delete($id);
        return response()->json([], 204);
    }
}
