<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductShipByDatesTest extends TestCase
{
    /**
     * @group productTests
     * @group displayDateTests
     */
    public function testChallengeExampleOne()
    {
        date_default_timezone_set("America/Los_Angeles");

        $product = new Product();

        $product->shipOnWeekends = false;
        $product->maxBusinessDaysToShip = 2;

        $product->getShipByDate('2017-10-02 00:00:00');

        $display_date = $product->ship_by_date_display;

        $this->assertEquals('Tuesday October 3rd, 2017', $display_date);
    }

    /**
     * @group productTests
     * @group displayDateTests
     */
    public function testChallengeExampleTwo()
    {
        date_default_timezone_set("America/Los_Angeles");

        $product = new Product();

        $product->shipOnWeekends = false;
        $product->maxBusinessDaysToShip = 12;

        $product->getShipByDate('2017-01-01 00:00:00');

        $display_date = $product->ship_by_date_display;

        $this->assertEquals('Monday January 16th, 2017', $display_date);
    }

    /**
     * @group productTests
     * @group displayDateTests
     */
    public function testChallengeExampleThree()
    {
        date_default_timezone_set("America/Los_Angeles");

        $product = new Product();

        $product->shipOnWeekends = true;
        $product->maxBusinessDaysToShip = 7;

        $product->getShipByDate('2017-01-01 00:00:00');

        $display_date = $product->ship_by_date_display;

        $this->assertEquals('Saturday January 7th, 2017', $display_date);
    }
}
