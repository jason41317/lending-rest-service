<?php

namespace App\Services;

use App\Models\Unit;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnitService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $units = $isPaginated
        ? Unit::paginate($perPage)
        : Unit::all();
      return $units;
    } catch (Exception $e) {
      Log::info('Error occured during UnitService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $unit = Unit::create($data);
      DB::commit();
      return $unit;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during UnitService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $unit = Unit::find($id);
      return $unit;
    } catch (Exception $e) {
      Log::info('Error occured during UnitService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $unit = Unit::find($id);
      $unit->update($data);
      DB::commit();
      return $unit;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during UnitService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $unit = Unit::find($id);
      $unit->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during UnitService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
