<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductViewController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function list(Request $request)
    {
        $sampleData = $this->getProductData();

        $sampleData = $this->calculateProductShipByDates($sampleData);

        return view('product_list', [
            'productData' => $sampleData
        ]);
    }

    /**
     * Calculate each product's ship-by date, according to the rules each one defines
     * DEVELOPER NOTE: I opted to do this processing server-side rather than via Jquery ...
     * ... because the request was to do this challenge in Laravel
     */
    private function calculateProductShipByDates($sampleData)
    {
        // give each product a string representation of the ship-by date
        foreach ($sampleData as $product)
        {
            // create a new Carbon datetime object, which initializes to the current time
            $shipByDateObject = Carbon::now();

            // get the maximum number of days before a product would ship, minus one - today counts as well
            // using max($value, 0) ensures it never goes negative (e.g. it would ship today, 0 lead time)
            $maxDaysToShip = max($product->maxBusinessDaysToShip - 1, 0);

            if ($product->shipOnWeekends !== true)
            {
                // if the product does not ship on weekends, add week days only
                $shipByDateObject->addWeekdays($maxDaysToShip);
            }
            else // product can ship on weekends - add the number of days as-is
            {
                $shipByDateObject->addDays($maxDaysToShip);
            }

            // example of below output: "Friday April 05th, 2019"
            $product->shipByDate = $shipByDateObject->format('l F dS, Y');
        }

        return $sampleData;
    }

    /**
     * Retrieve and return an array of objects containing product information
     */
    private function getProductData()
    {
        // this function would normally be an API call to an internal API
        // or directly use models to pull data from the database
        $sampleDataPath = storage_path('sampleData.json');
        $rawSampleData = file_get_contents($sampleDataPath);

        // fetch and decode the json file into objects
        $sampleData = json_decode($rawSampleData);

        return $sampleData;
    }
}
