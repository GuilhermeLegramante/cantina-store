<?php

namespace App\Repositories;

use App\Services\LogService;
use Illuminate\Support\Facades\DB;

class CsosnRepository
{
    private $table = 'csosn';

    private $baseQuery;

    public function __construct()
    {
        $this->baseQuery = DB::table($this->table)
            ->select(
                $this->table . '.id AS id',
                $this->table . '.code AS code',
                DB::raw("(SELECT CONCAT({$this->table}.code, ' - ', {$this->table}.description)) AS description"),
                $this->table . '.created_at AS createdAt',
                $this->table . '.updated_at AS updatedAt',
            );
    }

    public function all(string $search = null, string $sortBy = 'id', string $sortDirection = 'asc', string $perPage = '30')
    {
        return $this->baseQuery
            ->where([
                [$this->table . '.id', 'like', '%' . $search . '%'],
            ])
            ->orWhere([
                [$this->table . '.code', 'like', '%' . $search . '%'],
            ])
            ->orWhere([
                [$this->table . '.description', 'like', '%' . $search . '%'],
            ])
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

        $userId = DB::table($this->table)
            ->insertGetId(
                [
                    'code' => $data['code'],
                    'description' => $data['description'],
                    'user_id' => session()->get('userId'),
                    'created_at' => now(),
                ]
            );

        return $userId;
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
                    'code' => $data['code'],
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
