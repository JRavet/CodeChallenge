<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductPageTest extends TestCase
{

    /**
     * @group webpageTests
     * @group productTests
     */
    public function testProductListWebpage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
