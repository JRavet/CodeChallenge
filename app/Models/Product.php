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

        // initialize a collection; this will contain Product models, and is what is returned
        $collectionOfProducts = collect();

        // for each of the sample data objects, add the attributes of the object to a new model instance
        foreach ($sampleData as $productData)
        {
            // instantiate a new model instance
            $productModel = new self();

            // dynamically add each attribute of the object to the new model instance
            foreach ($productData as $key => $value)
            {
                // using ->{$key} syntax allows dynamic assignment at run-time
                // $key is evaluated first, e.g. "maxBusinessDaysToShip"
                // then it is treated as if that was coded in normally, e.g. $productModel->maxBusinessDaysToShip = $value
                $productModel->{$key} = $value;
            }

            // add the new, inflated model instance to the collection
            $collectionOfProducts[] = $productModel;
        }

        // return the collection of Product model instances with their new attributes
        return $collectionOfProducts;
    }

    /**
     * This function is what is known as an "accessor method"
     * It is implicitly called when attempting to access the attribute ship_by_date_display on any Product
     */
    public function getShipByDateDisplayAttribute()
    {
        // example of below output: "Friday April 5th, 2019"
        return $this->getShipByDate()->format('l F jS, Y');;
    }

    /**
     * Calculate the product's ship-by date, according to the rules defined by it
     * DEVELOPER NOTE: I opted to do this processing server-side rather than via Jquery ...
     * ... because the request was to do this challenge in Laravel
    **/
    public function getShipByDate($startDatetime=null)
    {
        // check if the value exists already - prevents excess work caused by repeated usage
        if (!isset($this->shipByDate))
        {
            // create a new Carbon datetime object, which initializes to the current time
            $shipByDateObject = new Carbon($startDatetime);

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
        }

        return $this->shipByDate;
    }
}
