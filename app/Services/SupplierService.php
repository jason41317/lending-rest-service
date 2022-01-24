<?php

namespace App\Services;

use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $suppliers = $isPaginated
        ? Supplier::paginate($perPage)
        : Supplier::all();
      return $suppliers;
    } catch (Exception $e) {
      Log::info('Error occured during SupplierService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $supplier = Supplier::create($data);
      DB::commit();
      return $supplier;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during SupplierService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $supplier = Supplier::find($id);
      return $supplier;
    } catch (Exception $e) {
      Log::info('Error occured during SupplierService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $supplier = Supplier::find($id);
      $supplier->update($data);
      DB::commit();
      return $supplier;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during SupplierService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $supplier = Supplier::find($id);
      $supplier->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during SupplierService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
