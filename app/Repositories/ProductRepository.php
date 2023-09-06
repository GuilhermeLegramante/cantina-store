<?php

namespace App\Repositories;

use App\Repositories\Traits\WithSingleColumnUpdate;
use App\Services\LogService;
use Illuminate\Support\Facades\DB;
use Storage;
use Str;

class ProductRepository
{
    use WithSingleColumnUpdate;

    private $table = 'products';

    private $baseQuery;

    public function __construct()
    {
        $this->baseQuery = DB::table($this->table)
            ->select(
                $this->table . '.id AS id',
                $this->table . '.manufacturer_id AS manufacturerId',
                $this->table . '.category_id AS categoryId',
                $this->table . '.description AS description',
                $this->table . '.code AS code',
                $this->table . '.barcode AS barcode',
                $this->table . '.weight AS weight',
                $this->table . '.measurement_unit_id AS measurementUnitId',
                $this->table . '.cest_ncm_id AS cestncmId',
                $this->table . '.cfop_id AS cfopId',
                $this->table . '.csosn_id AS csosnId',
                $this->table . '.cost_price AS costPrice',
                $this->table . '.created_at AS createdAt',
                $this->table . '.updated_at AS updatedAt',
                DB::raw("(select COUNT(`product_images`.`id`) from products AS products_2 inner join `product_images` on `product_images`.`product_id` = `products_2`.`id` where products.id = products_2.id
                ) as totalImages"),
                DB::raw("(select ifnull((SELECT product_images.path FROM `product_images` WHERE product_id = {$this->table}.id limit 1), '')) as image"),
            );
    }

    public function all(string $search = null, string $sortBy = 'id', string $sortDirection = 'asc', string $perPage = '30')
    {
        return $this->baseQuery
            ->where([
                [$this->table . '.id', 'like', '%' . $search . '%'],
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

        $registerId = DB::table($this->table)
            ->insertGetId(
                [
                    'manufacturer_id' => $data['manufacturerId'],
                    'category_id' => $data['categoryId'],
                    'description' => $data['description'],
                    'code' => isset($data['code']) ? $data['code'] : null,
                    'barcode' => isset($data['barcode']) ? $data['barcode'] : null,
                    'weight' => isset($data['weight']) ? $data['weight'] : null,
                    'measurement_unit_id' => isset($data['measurementUnitId']) ? $data['measurementUnitId'] : null,
                    'cest_ncm_id' => isset($data['cestncmId']) ? $data['cestncmId'] : null,
                    'cfop_id' => isset($data['cfopId']) ? $data['cfopId'] : null,
                    'csosn_id' => isset($data['csosnId']) ? $data['csosnId'] : null,
                    'cost_price' => isset($data['costPrice']) ? $data['costPrice'] : null,
                    'user_id' => session()->get('userId'),
                    'created_at' => now(),
                ]
            );

        if (isset($data['images'])) {
            $this->uploadFiles($data['images'], $registerId);
        }

        if (isset($data['tags'])) {
            $this->insertTags($data['tags'], $registerId);
        }

        return $registerId;
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
                    'manufacturer_id' => $data['manufacturerId'],
                    'category_id' => $data['categoryId'],
                    'description' => $data['description'],
                    'code' => isset($data['code']) ? $data['code'] : null,
                    'barcode' => isset($data['barcode']) ? $data['barcode'] : null,
                    'weight' => isset($data['weight']) ? $data['weight'] : null,
                    'measurement_unit_id' => isset($data['measurementUnitId']) ? $data['measurementUnitId'] : null,
                    'cest_ncm_id' => isset($data['cestncmId']) ? $data['cestncmId'] : null,
                    'cfop_id' => isset($data['cfopId']) ? $data['cfopId'] : null,
                    'csosn_id' => isset($data['csosnId']) ? $data['csosnId'] : null,
                    'cost_price' => isset($data['costPrice']) ? $data['costPrice'] : null,
                    'user_id' => session()->get('userId'),
                    'updated_at' => now(),
                ]
            );

        if (isset($data['images'])) {
            $this->uploadFiles($data['images'], $data['recordId']);
        }

        if (isset($data['tags'])) {
            $this->insertTags($data['tags'], $data['recordId']);
        }
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
        $product = $this->baseQuery
            ->where($this->table . '.id', $id)
            ->get()
            ->first();

        $images = DB::table('product_images')
            ->where('product_images.product_id', $id)
            ->select(
                'product_images.id AS id',
                'product_images.path AS path',
            )->get();

        $product->images = $images;

        $tags = DB::table('product_tags')
            ->where('product_tags.product_id', $id)
            ->select(
                'product_tags.id AS id',
                'product_tags.tag AS tag',
            )->get();

        $product->tags = $tags;

        return $product;
    }

    private function uploadFiles($images, $productId)
    {
        foreach ($images as $file) {
            $path = '_cantina-store/produtos';

            $filename = Str::random(4) . '_' . $file->getClientOriginalName();

            $s3Path = Storage::disk('s3')->putFileAs($path, $file, $filename);

            DB::table('product_images')
                ->insertGetId(
                    [
                        'path' => $s3Path,
                        'user_id' => session()->get('userId'),
                        'product_id' => $productId,
                        'created_at' => now(),
                    ]
                );
        }
    }

    private function insertTags($tags, $productId)
    {
        DB::table('product_tags')
            ->where('product_id', $productId)
            ->delete();

        foreach ($tags as $key => $tag) {
            DB::table('product_tags')
                ->insert(
                    [
                        'product_id' => $productId,
                        'tag' => $tag,
                        'user_id' => session()->get('userId'),
                        'created_at' => now(),
                    ]
                );
        }
    }

    public function deleteImage($id)
    {
        DB::table('product_images')
            ->where('id', $id)
            ->delete();
    }
}
