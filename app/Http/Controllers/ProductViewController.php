<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class ProductViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function list(Request $request)
    {
        $products = Product::getSampleData();

        // example of below output: "Friday April 5th, 2019"
        $orderDate = (Carbon::now())->format('l F jS, Y');

        return view('product_list', [
            'products' => $products,
            'orderDate' => $orderDate
        ]);
    }

}
