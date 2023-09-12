<?php

namespace App\Repositories;

use App\Repositories\Traits\WithSingleColumnUpdate;
use App\Services\LogService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MovementRepository {
    use WithSingleColumnUpdate;

    const optIn = 'E';
    const optOut = 'S';
    const optReturnIn = 'EE';
    const optReturnOut = 'ES';

    private $table = 'movements';
    private $baseQuery;
    private $operation;

    private $fk;

    public function __construct() {
        $this->fk = (object) [
            'entryProd' => 'entry_products',
            'outputProd' => 'output_products',
            'products' => 'products',
            'entry' => 'entry'
        ];
    }

    /**
     * Retorna uma collection com o saldo do(s) produto(s) por loja (storeId)
     * ou geral, de toda a organização
     */
    public function getBalance(int $productId = -1, int $storeId = -1) : Collection {
        return
            DB::table($this->table)
                ->select(
                    $this->fk->entryProd . '.product_id AS productId',
                    $this->fk->products . '.code AS code',
                    $this->fk->products . '.barcode AS barCode',
                    $this->fk->products . '.description AS description',
                    DB::raw('SUM(IF(' . $this->table . '.operation IN ("' . self::optIn . '", "' . self::optReturnOut . '"), 1, 0)) AS entryAmount'),
                    DB::raw('MIN(CASE WHEN ' . $this->table . '.operation IN ("' . self::optIn . '", "' . self::optReturnOut . '") THEN ' . $this->table . '.value END) AS minEntryValue'),
                    DB::raw('MAX(CASE WHEN ' . $this->table . '.operation IN ("' . self::optIn . '", "' . self::optReturnOut . '") THEN ' . $this->table . '.value END) AS maxEntryValue'),
                    DB::raw('AVG(CASE WHEN ' . $this->table . '.operation IN ("' . self::optIn . '", "' . self::optReturnOut . '") THEN ' . $this->table . '.value END) AS avgEntryValue'),
                    DB::raw('SUM(IF(' . $this->table . '.operation IN ("' . self::optOut . '", "' . self::optReturnIn . '"), 1, 0)) AS outputAmount'),
                    DB::raw('MIN(CASE WHEN ' . $this->table . '.operation IN ("' . self::optOut . '", "' . self::optReturnIn . '") THEN ' . $this->table . '.value END) AS minOutputValue'),
                    DB::raw('MAX(CASE WHEN ' . $this->table . '.operation IN ("' . self::optOut . '", "' . self::optReturnIn . '") THEN ' . $this->table . '.value END) AS maxOutputValue'),
                    DB::raw('AVG(CASE WHEN ' . $this->table . '.operation IN ("' . self::optOut . '", "' . self::optReturnIn . '") THEN ' . $this->table . '.value END) AS avgOutputValue'),
                    DB::raw('SUM(IF(' . $this->table . '.operation IN ("' . self::optIn . '", "' . self::optReturnOut . '"), ' . $this->table . '.amout, -' . $this->table . '.amout)) AS totalAvailable')
                )

                ->join($this->fk->entryProd, $this->fk->entryProd . '.id', '=', $this->table . '.entry_product_id')
                ->join($this->fk->products, $this->fk->products . '.id', '=', $this->fk->entryProd . '.product_id')
                ->join($this->fk->entry, $this->fk->entry . '.id', '=', $this->fk->entryProd . '.entry_id')
                
                ->where($this->fk->entry . '.store_id', $storeId == -1 ? '<>' : '=', $storeId)
                ->where($this->fk->entryProd . '.product_id', $productId == -1 ? '<>' : '=', $productId)

                ->groupBy($this->fk->entryProd . '.product_id')
            ->get();
    }

    public function findById(int $id) : Collection {
        return DB::table($this->table)->where($this->table . '.id', '=', $id)->get();
    }

    /**
     * Salvar o movimento e retorna seu ID.
     */
    public function save($data) : int {
        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            LogService::optInsert,
            date('Y-m-d H:i:s'),
            json_encode($data),
            null
        );

        $movId = DB::table($this->table)->insertGetId([
            'entry_product_id' => $data['entry_product_id'],
            'output_product_id' => isset($data['output_product_id']) ? $data['output_product_id'] : null,
            'operation' => $data['operation'],
            'amout' => $data['amout'],
            'value' => $data['value'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
        ]);

        return $movId;
    }

    /**
     * Deleta o movimento informado
     */
    public function delete(int $id) {
        $oldData = $this->findById($id);

        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            LogService::optDelete,
            date('Y-m-d H:i:s'),
            json_encode($oldData),
            null
        );

        DB::table($this->table)->where('id', '=', $id)->delete();
    }
}