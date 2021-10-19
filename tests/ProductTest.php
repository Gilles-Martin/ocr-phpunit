<?php

namespace App\Tests;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function testComputeTVAProductTypeFood()
    {
        $product = new Product('nom', Product::FOOD_PRODUCT, 10);

        $result = $product->computeTVA();

        $this->assertSame(0.55, $result);
    }

    public function testComputeTVAProductOtherType()
    {
        $product = new Product('toto', 'other', 10);

        $result = $product->computeTVA();

        $this->assertSame(1.96, $result);
    }

    public function testNegativePriceComputeTVA()
    {
        $product = new Product('toto', 'other', -1);

        $this->expectException('LogicException');
        $product->computeTVA();
    }

    /**
     * @dataProvider pricesForFoodProduct
     */
    public function testcomputeTVAFoodProduct($price, $expectedTva)
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, $price);

        $this->assertSame($expectedTva, $product->computeTVA());
    }

    public function pricesForFoodProduct()
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }

}
