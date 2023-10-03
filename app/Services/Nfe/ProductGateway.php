<?php

namespace App\Services\Nfe;

use App\Repositories\CestncmRepository;
use App\Repositories\CfopRepository;
use App\Repositories\MeasurementUnitRepository;
use App\Repositories\ProductRepository;
use App\Services\Mask;

/**
 * Classe para direcionamento dos dados dos produtos a partir da entrada via arquivo xml da NF-e
 *
 */
class ProductGateway
{
    protected $products = [];

    protected $cestNcmId;

    protected $cfopId;

    protected $measurementUnitId;

    protected $productId;

    protected $code;

    protected $barCode;

    protected $description;

    public function __construct(Invoice $invoice)
    {
        if (count($invoice->products) > 0) {
            foreach ($invoice->products as $product) {
                $this->setCestNcm($product);

                $this->setCfop($product);

                $this->setMeasurementUnit($product);

                $this->setProduct($product);
            }
        }
    }

    private function setCestNcm($product)
    {
        $repository = new CestncmRepository();
        $cestNcm = $repository->findByCestAndNcm($product->cest, $product->ncm);
        $this->cestNcmId = isset($cestNcm) ? $cestNcm->id : null;
    }

    private function setCfop($product)
    {
        $repository = new CfopRepository();
        $cfop = $repository->findByCode($product->cfop);
        $this->cfopId = isset($cfop) ? $cfop->id : null;
    }

    private function setMeasurementUnit($product)
    {
        $repository = new MeasurementUnitRepository();
        $measurementUnit = $repository->findByDescription($product->measurement);

        if (isset($measurementUnit)) {
            $this->measurementUnitId = $measurementUnit->id;
        } else {
            $this->measurementUnitId = $repository->save(
                [
                    'description' => $product->measurement,
                    'acronym' => $product->measurement,
                ]
            );
        }
    }

    private function setProduct($product)
    {
        $repository = new ProductRepository();
        $storedProduct = $repository->findByCode($product->code);

        $this->code = isset($product->code) ? $product->code : null;
        $this->barCode = isset($product->barCode) ? $product->barCode : null;
        $this->description = $product->description;

        if (isset($storedProduct)) {
            $this->productId = $storedProduct->id;
        } else {
            $repository = new ProductRepository();
            $this->productId = $repository->save(
                [
                    'description' => $this->description,
                    'code' => $this->code,
                    'barcode' => $this->barCode,
                    'measurementUnitId' => $this->measurementUnitId,
                    'cestncmId' => $this->cestNcmId,
                    'cfopId' => $this->cfopId,
                ]
            );
        }

        $prod = [
            'id' => $this->productId,
            'description' => $this->description,
            'quantity' => $product->amount,
            'value' => Mask::money($product->unitaryValue),
        ];

        array_push($this->products, $prod);
    }

    public function getProducts()
    {
        return $this->products;
    }
}
