<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Services\Nfe\Invoice;

class TestController extends Controller
{
    public function table()
    {
        return view('parent.test-table');
    }

    public function xml() : string {
        $xml = Storage::disk('local')->get('Cantina-NFe.xml');

        $xmlObj = simplexml_load_string($xml);
        $json = json_encode($xmlObj);
        $res = json_decode($json, true);

        // dd($res['NFe']['infNFe']['@attributes']['Id']); // ID da NF-e
        // dd($res['NFe']['infNFe']['ide']['cNF']); // Código sequencial da NF-e
        // dd($res['NFe']['infNFe']['det']); // Itens da NF-e
        // dd($res);

        $inv = new Invoice($xml);

        dd($inv->identify->id);

        $collect = (object) $res['NFe']['infNFe']['det'];
        dd($collect);

        return $xml;
    }
}
