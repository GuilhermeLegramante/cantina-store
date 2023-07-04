<?php

namespace App\Http\Controllers;

use DB;
use File;
use Http;
use Illuminate\Routing\Controller;
use Response;
use Str;

class MainController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function findProductsCode()
    {
        $open = fopen("C:\\products.csv", "r");

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        $handle = fopen("C:\Users\guilh\Documents\produtos.csv", 'w');

        fputcsv($handle, [
            "Descrição do Produto",
            "CEST/NCM",
            "Código CEST",
            "Código NCM",
        ]);

        if ($open !== false) {
            while (($data = fgetcsv($open, 10000, ",")) !== false) {
                $search = Str::words($data[0], 1, '');

                $product = [];

                $product['Produto'] = $data[0];

                $result = DB::table('cest_ncm')
                    ->where('description', 'like', $search . '%')
                    ->select(
                        'description',
                        'cest',
                        'ncm',
                    )
                    ->get()
                    ->first();

                if (isset($result)) {
                    $product['Descrição CEST/NCM'] = $result->description;
                    $product['Código CEST'] = $result->cest;
                    $product['Código NCM'] = $result->ncm;

                    fputcsv($handle, [
                        $data[0],
                        $result->description,
                        $result->cest,
                        $result->ncm,
                    ]);
                } else {
                    fputcsv($handle, [
                        $data[0],
                    ]);
                }

                $array[] = $product;
            }

            fclose($open);
            fclose($handle);
        }

        return Response::download("C:\Users\guilh\Documents\produtos.csv", "produtos.csv", $headers);

        dd($array);
    }

    public function findProductFromCosmosApi()
    {
        $open = fopen("C:\\codigos.csv", "r");

        $products = [];

        if ($open !== false) {
            while (($data = fgetcsv($open, 10000, ",")) !== false) {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'X-Cosmos-Token' => '7fKZuUaMOagzHoCBrR240g',
                ])->get('https://api.cosmos.bluesoft.com.br/gtins/' . $data[0]);

                dd($response->body());

                array_push($products, $response->body());
            }
        }

        $json = json_encode($products);

        $fileName = time() . '_produtos.json';
        $fileStorePath = public_path('\\upload\\json\\' . $fileName);

        File::put($fileStorePath, $json);

        return response()->download($fileStorePath);
    }
}
