<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CartService;


class CartServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testTotal()
    {

    	$data = [
    		'base_price' => 10,
    		'spacing_cost' => 10,
    		'work_level_cost' => 50,
    		'urgency_cost' => 20,
    		'number_of_pages' => 5,
    		'total_additional_services_cost' => 10
    		// 'vat' => 100
    	];

        $foo = self::getMethod('calculate');
        $cartService = new CartService();
        $response = $foo->invokeArgs($cartService, [$data]);

        $this->assertEquals(410, $response);
    }

   
    protected static function getMethod($name) {
          $class = new \ReflectionClass('App\Services\CartService');
          $method = $class->getMethod($name);
          $method->setAccessible(true);
          return $method;
    }
    // public function testTotalFailed()
    // {

    // 	$data = [
    // 		'base_price' => 10,
    // 		'spacing_cost' => 10,
    // 		'work_level_cost' => 50,
    // 		'urgency_cost' => 20,
    // 		'number_of_pages' => 5,
    // 		'total_additional_services_cost' => 10
    // 		// 'vat' => 100
    // 	];

    // 	$cartService = new CartService();
    //     $this->assertEquals(470, $cartService->total($data));
    // }
}
