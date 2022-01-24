<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $purchaseOrders = $isPaginated
        ? PurchaseOrder::paginate($perPage)
        : PurchaseOrder::all();
      return $purchaseOrders;
    } catch (Exception $e) {
      Log::info('Error occured during PurchaseOrderService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $products)
  {
    DB::beginTransaction();
    try {
      $purchaseOrder = PurchaseOrder::create($data);
      $items = [];
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity']
        ];
      }

      $purchaseOrder->products()->sync($items);
      DB::commit();
      return $purchaseOrder;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PurchaseOrderService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $purchaseOrder = PurchaseOrder::find($id);
      return $purchaseOrder;
    } catch (Exception $e) {
      Log::info('Error occured during PurchaseOrderService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $products, int $id)
  {
    DB::beginTransaction();
    try {
      $purchaseOrder = PurchaseOrder::find($id);
      $purchaseOrder->update($data);

      $items = [];
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity']
        ];
      }

      $purchaseOrder->products()->sync($items);

      DB::commit();
      return $purchaseOrder;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PurchaseOrderService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $purchaseOrder = PurchaseOrder::find($id);
      $purchaseOrder->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PurchaseOrderService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
