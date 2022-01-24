<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $categories = $isPaginated
        ? Category::paginate($perPage)
        : Category::all();
      return $categories;
    } catch (Exception $e) {
      Log::info('Error occured during CategoryService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $category = Category::create($data);
      DB::commit();
      return $category;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during CategoryService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $category = Category::find($id);
      return $category;
    } catch (Exception $e) {
      Log::info('Error occured during CategoryService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $category = Category::find($id);
      $category->update($data);
      DB::commit();
      return $category;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during CategoryService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $category = Category::find($id);
      $category->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during CategoryService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
