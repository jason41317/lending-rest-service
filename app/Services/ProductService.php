<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $products = $isPaginated
        ? Product::paginate($perPage)
        : Product::all();
      $products->load('inventories');
      $products->append('inventory_count');
      return $products;
    } catch (Exception $e) {
      Log::info('Error occured during ProductService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $product = Product::create($data);
      DB::commit();
      return $product;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ProductService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $product = Product::find($id);
      return $product;
    } catch (Exception $e) {
      Log::info('Error occured during ProductService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $product = Product::find($id);
      $product->update($data);
      DB::commit();
      return $product;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ProductService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $product = Product::find($id);
      $product->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ProductService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
