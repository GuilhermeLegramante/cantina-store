<?php

namespace App\Repositories;

use App\Repositories\Traits\WithSingleColumnUpdate;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;

class StockRepository
{
    use WithSingleColumnUpdate;

    private $table = 'movements';

    private $baseQuery;

    const optIn = 'E';
    const optOut = 'S';
    const optReturnIn = 'EE';
    const optReturnOut = 'ES';

    private $operation;

    private $fk;

    public function __construct()
    {
        $this->fk = (object) [
            'entryProd' => 'entry_products',
            'outputProd' => 'output_products',
            'products' => 'products',
            'entry' => 'entry',
        ];

        $this->baseQuery = DB::table($this->table)
            ->join($this->fk->entryProd, $this->fk->entryProd . '.id', '=', $this->table . '.entry_product_id')
            ->join($this->fk->products, $this->fk->products . '.id', '=', $this->fk->entryProd . '.product_id')
            ->join($this->fk->entry, $this->fk->entry . '.id', '=', $this->fk->entryProd . '.entry_id')
            ->select(
                $this->table . '.id AS id',
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
                DB::raw('SUM(IF(' . $this->table . '.operation IN ("' . self::optIn . '", "' . self::optReturnOut . '"), ' . $this->table . '.amount, -' . $this->table . '.amount)) AS totalAvailable')
            );
    }

    public function all(string $search = null, string $sortBy = 'id', string $sortDirection = 'asc', string $perPage = '30', int $productId = -1, int $storeId = -1)
    {
        return $this->baseQuery
            ->where(function ($q) use ($search, $storeId, $productId) {
                $q->where(function ($query) use ($search, $storeId, $productId) {
                    $query
                        ->where([
                            [$this->table . '.id', 'like', '%' . $search . '%'],
                            [$this->fk->entry . '.store_id', $storeId == -1 ? '<>' : '=', $storeId],
                            [$this->fk->entryProd . '.product_id', $productId == -1 ? '<>' : '=', $productId],
                        ]);
                })
                    ->orWhere([
                        [$this->fk->products . '.description', 'like', '%' . $search . '%'],
                        [$this->fk->entry . '.store_id', $storeId == -1 ? '<>' : '=', $storeId],
                        [$this->fk->entryProd . '.product_id', $productId == -1 ? '<>' : '=', $productId],
                    ]);
            })
            ->groupBy($this->fk->entryProd . '.product_id')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function allSimplified()
    {
        return $this->baseQuery->get();
    }

    public function save($data)
    {
        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            'I',
            date('Y-m-d H:i:s'),
            json_encode($data),
            null
        );

        // Insere a entrada
        $entryId = DB::table('entry')
            ->insertGetId(
                [
                    'user_id' => session()->get('userId'),
                    'store_id' => $data['storeId'],
                    'nfe_id' => isset($data['nfeId']) ? $data['nfeId'] : null,
                    'nfe_code' => isset($data['nfeCode']) ? $data['nfeCode'] : null,
                    'date' => isset($data['date']) ? $data['date'] : now()->format('Y-m-d'),
                    'created_at' => now(),
                ]
            );

        // Insere os produtos
        foreach ($data['products'] as $product) {
            $productEntry = DB::table('entry_products')
                ->insertGetId(
                    [
                        'entry_id' => $entryId,
                        'product_id' => $product['id'],
                        'expiration_date' => isset($data['expirationDate']) ? $data['expirationDate'] : null,
                        'created_at' => now(),
                    ]
                );

            // Insere o movimento de entrada de cada produto
            DB::table('movements')
                ->insertGetId(
                    [
                        'entry_product_id' => $productEntry,
                        'operation' => 'E',
                        'amount' => $product['quantity'],
                        'value' => $product['value'],
                        'created_at' => now(),
                    ]
                );
        }
    }

    public function update($data)
    {
        $oldData = $this->findById($data['recordId']);

        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            'U',
            date('Y-m-d H:i:s'),
            json_encode($oldData),
            json_encode($data)
        );

        DB::table($this->table)
            ->where('id', $data['recordId'])
            ->update(
                [
                    'description' => $data['description'],
                    'user_id' => session()->get('userId'),
                    'updated_at' => now(),
                ]
            );
    }

    public function delete($data)
    {
        $oldData = $this->findById($data['recordId']);

        LogService::saveLog(
            session()->get('userId'),
            $this->table,
            'D',
            date('Y-m-d H:i:s'),
            json_encode($oldData),
            null
        );

        DB::table($this->table)
            ->where('id', $data['recordId'])
            ->delete();
    }

    public function findById($id)
    {
        return $this->baseQuery
            ->where($this->table . '.id', $id)
            ->get()
            ->first();
    }
}
