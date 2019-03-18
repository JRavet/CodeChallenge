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

    public function list()
    {
        $products = Product::getSampleData();

        // example of below output: "Friday April 5th, 2019"
        $orderDate = (Carbon::now())->format('l F jS, Y');

        return view('product_list', [
            'products' => $products,
            'orderDate' => $orderDate
        ]);
    }

    public function ajaxReloadProductListPartial(Request $request)
    {
        $userOrderDate = $request->orderDate;

        // example of below output: "Friday April 5th, 2019"
        $orderDate = (new Carbon($userOrderDate))->format('l F jS, Y');

        $products = Product::getSampleData();

        foreach ($products as $product)
        {
            // set the shipByDate now using the provided date, so it doesn't default to the current time
            $product->getShipByDate($userOrderDate);
        }

        $productListHtml = view('product_list_partial', [
            'products' => $products
        ])->render();

        return json_encode([
            'success' => true,
            'orderDateHeaderText' => $orderDate,
            'productListHtml' => $productListHtml
        ]);
    }

}
