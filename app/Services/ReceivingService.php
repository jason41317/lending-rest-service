<?php

namespace App\Services;

use App\Models\Receiving;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReceivingService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $receivings = $isPaginated
        ? Receiving::paginate($perPage)
        : Receiving::all();
      return $receivings;
    } catch (Exception $e) {
      Log::info('Error occured during ReceivingService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $products)
  {
    DB::beginTransaction();
    try {
      $receiving = Receiving::create($data);
      $items = [];
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity'],
          'type' => 'IN'
        ];
      }

      $receiving->products()->sync($items);
      DB::commit();
      return $receiving;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ReceivingService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $receiving = Receiving::find($id);
      $receiving->load('products');
      return $receiving;
    } catch (Exception $e) {
      Log::info('Error occured during ReceivingService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $products, int $id)
  {
    DB::beginTransaction();
    try {
      $receiving = Receiving::find($id);
      $receiving->update($data);

      $items = [];
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity'],
          'type' => 'IN'
        ];
      }

      $receiving->products()->sync($items);

      DB::commit();
      return $receiving;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ReceivingService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $receiving = Receiving::find($id);
      $receiving->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ReceivingService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
