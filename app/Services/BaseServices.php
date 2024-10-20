<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class BaseServices
{
    public function aplicarSelect($query, $select = [])
    {
        if (!empty($select)) {
            return $query->select($select);
        }

        return $query;
    }

    public function aplicarRelacionamento($query, $relacionamentos = [])
    {
        if (!empty($relacionamentos)) {
            return $query->with($relacionamentos);
        }

        return $query;
    }

    public function aplicarOrdenacao($query, $ordenacao = [])
    {
        if (!empty($ordenacao))
        {
            return $query->orderBy($ordenacao[0], $ordenacao[1] ?? '');
        }
        else
        {
            return $query->orderBy('id', 'desc');
        }
    }

    function transaction($callback, $callback_pos_commit = null) : bool
    {
        DB::beginTransaction();

        try
        {
            $callback();
            DB::commit();

            if(! is_null($callback_pos_commit)) $callback_pos_commit();
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
