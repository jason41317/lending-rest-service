<?php

namespace App\Services;

use App\Models\Adjustment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdjustmentService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $adjustments = $isPaginated
        ? Adjustment::paginate($perPage)
        : Adjustment::all();
      return $adjustments;
    } catch (Exception $e) {
      Log::info('Error occured during AdjustmentService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $products)
  {
    DB::beginTransaction();
    try {
      $adjustment = Adjustment::create($data);
      $items = [];
      $type = $adjustment->adjustment_type_id === 1 ? 'IN' : 'OUT';
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity'],
          'type' => $type
        ];
      }

      $adjustment->products()->sync($items);
      DB::commit();
      return $adjustment;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AdjustmentService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $adjustment = Adjustment::find($id);
      $adjustment->load('products');
      return $adjustment;
    } catch (Exception $e) {
      Log::info('Error occured during AdjustmentService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $products, int $id)
  {
    DB::beginTransaction();
    try {
      $adjustment = Adjustment::find($id);
      $adjustment->update($data);

      $items = [];
      $type = $adjustment->adjustment_type_id === 1 ? 'IN' : 'OUT';
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity'],
          'type' => $type
        ];
      }

      $adjustment->products()->sync($items);

      DB::commit();
      return $adjustment;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AdjustmentService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $adjustment = Adjustment::find($id);
      $adjustment->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AdjustmentService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
