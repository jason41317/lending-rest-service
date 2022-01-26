<?php

namespace App\Services;

use App\Models\Issuance;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IssuanceService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $issuances = $isPaginated
        ? Issuance::paginate($perPage)
        : Issuance::all();
      return $issuances;
    } catch (Exception $e) {
      Log::info('Error occured during IssuanceService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $products)
  {
    DB::beginTransaction();
    try {
      $issuance = Issuance::create($data);
      $items = [];
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity'],
          'type' => 'OUT'
        ];
      }

      $issuance->products()->sync($items);
      DB::commit();
      return $issuance;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during IssuanceService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $issuance = Issuance::find($id);
      $issuance->load('products');
      return $issuance;
    } catch (Exception $e) {
      Log::info('Error occured during IssuanceService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $products, int $id)
  {
    DB::beginTransaction();
    try {
      $issuance = Issuance::find($id);
      $issuance->update($data);

      $items = [];
      foreach ($products as $product) {
        $items[$product['id']] = [
          'cost' => $product['cost'],
          'quantity' => $product['quantity'],
          'type' => 'OUT'
        ];
      }

      $issuance->products()->sync($items);

      DB::commit();
      return $issuance;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during IssuanceService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $issuance = Issuance::find($id);
      $issuance->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during IssuanceService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
