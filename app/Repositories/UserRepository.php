<?php

namespace App\Repositories;

use App\Repositories\Traits\WithSingleColumnUpdate;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    use WithSingleColumnUpdate;

    private $table = 'users';

    private $baseQuery;

    public function __construct()
    {
        $this->baseQuery = DB::table($this->table)
            ->select(
                $this->table . '.id AS id',
                $this->table . '.name AS name',
                $this->table . '.name AS description',
                $this->table . '.login AS login',
                $this->table . '.email AS email',
                $this->table . '.is_admin AS isAdmin',
                $this->table . '.created_at AS createdAt',
                $this->table . '.updated_at AS updatedAt',
            );
    }

    public function all(string $search = null, string $sortBy = 'name', string $sortDirection = 'asc', string $perPage = '30')
    {
        return $this->baseQuery
            ->where([
                [$this->table . '.name', 'like', '%' . $search . '%'],
            ])
            ->orWhere([
                [$this->table . '.login', 'like', '%' . $search . '%'],
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
                    'name' => $data['name'],
                    'login' => $data['login'],
                    'email' => isset($data['email']) ? $data['email'] : null,
                    'password' => sha1($data['password']),
                    'is_admin' => $data['isAdmin'],
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
                    'name' => $data['name'],
                    'login' => $data['login'],
                    'email' => isset($data['email']) ? $data['email'] : null,
                    'password' => sha1($data['password']),
                    'is_admin' => $data['isAdmin'],
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

    public function populate() {
        // 7c4a8d09ca3762af61e59520943dc26494f8941b = 123456
        // a66961a27dd49978b614a8f029f551b481954c3f = USER1234 (By design, sempre a senha maiúscula)

        DB::table($this->table)->insertOrIgnore([
            ['login' => 'ADMIN', 'name' => 'ADMINISTRADOR', 'password' => '7c4a8d09ca3762af61e59520943dc26494f8941b', 'is_admin' => true, 'created_at' => now()],
            ['login' => 'USER', 'name' => 'USUARIO', 'password' => 'a66961a27dd49978b614a8f029f551b481954c3f', 'is_admin' => false, 'created_at' => now()]
        ]);
    }
}
