<?php

namespace App\Services;

use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function list(bool $isPaginated, int $perPage)
    {
        try {
            $customers = $isPaginated
                ? Customer::paginate($perPage)
                : Customer::all();
            return $customers;
        } catch (Exception $e) {
            Log::info('Error occured during CustomerService list method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            $Customer = Customer::create($data);
            DB::commit();
            return $Customer;
        } catch (Exception $e) {
            DB::rollback();
            Log::info('Error occured during CustomerService store method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    public function get(int $id)
    {
        try {
            $Customer = Customer::find($id);
            return $Customer;
        } catch (Exception $e) {
            Log::info('Error occured during CustomerService get method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $Customer = Customer::find($id);
            $Customer->update($data);
            DB::commit();
            return $Customer;
        } catch (Exception $e) {
            DB::rollback();
            Log::info('Error occured during CustomerService update method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $Customer = Customer::find($id);
            $Customer->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::info('Error occured during CustomerService delete method call: ');
            Log::info($e->getMessage());
            throw $e;
        }
    }
}