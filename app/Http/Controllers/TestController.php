<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

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
        dd($res['NFe']['infNFe']['det']); // Itens da NF-e

        return $xml;
    }
}
