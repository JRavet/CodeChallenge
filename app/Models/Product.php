<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    /**
     * Retrieve and return a collection of Products created from a sample json input file
     */
    public static function getSampleData()
    {
        // this function would normally be an API call to an internal API
        // or directly use models to pull data from the database
        $sampleDataPath = storage_path('sampleData.json');
        $rawSampleData = file_get_contents($sampleDataPath);

        // fetch and decode the json file into objects
        $sampleData = json_decode($rawSampleData);

        $collectionOfProducts = collect();

        foreach ($sampleData as $productData)
        {
            $productModel = new self();

            foreach ($productData as $key => $value)
            {
                $productModel->{$key} = $value;
            }

            $collectionOfProducts[] = $productModel;
        }

        return $collectionOfProducts;
    }

    /**
     * Calculate the product's ship-by date, according to the rules defined by it
     * DEVELOPER NOTE: I opted to do this processing server-side rather than via Jquery ...
     * ... because the request was to do this challenge in Laravel
     * This function is what is known as an "accessor method"
     * It is implicitly called when attempting to access the attribute ship_by_date_display on any Product
     */
    public function getShipByDateDisplayAttribute()
    {
        // if it hasn't yet been calculated, we need to find out what this product's ship-by date is
        if (!isset($this->shipByDate))
        {
            // this check prevents repeated calls from doing excess work
            $this->getShipByDate(); // caches the value to an attribute named "shipByDate"
        }

        // example of below output: "Friday April 05th, 2019"
        return $this->shipByDate->format('l F dS, Y');;
    }

    public function getShipByDate()
    {
        // create a new Carbon datetime object, which initializes to the current time
        $shipByDateObject = Carbon::now();

        // get the maximum number of days before a product would ship, minus one - today counts as well
        // using max($value, 0) ensures it never goes negative (e.g. it would ship today, 0 lead time)
        $maxDaysToShip = max($this->maxBusinessDaysToShip - 1, 0);

        if ($this->shipOnWeekends !== true)
        {
            // if the product does not ship on weekends, add week days only
            $shipByDateObject->addWeekdays($maxDaysToShip);
        }
        else // product can ship on weekends - add the number of days as-is
        {
            $shipByDateObject->addDays($maxDaysToShip);
        }

        $this->shipByDate = $shipByDateObject;

        return $this->shipByDate;
    }
}
