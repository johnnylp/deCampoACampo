<?php

namespace App\Transformers;

use App\Models\Product;

class ProductOutputTransformer
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function getAll()
    {
        $products = $this->product->getAll();

        if ($products['response'] == "false") {
            return $products;
        }

        foreach ($products['response'] as $product) {
            $product = (array)$product;
            $product['price_usd'] = number_format(($product['price'] / USD_ARS_EXCHANGE_PRICE), 2, ',', '.');
            $product['price'] = number_format($product['price'], 2, ',', '.');
            $productFinal[] = $product;
        }


        $finalArray = array_merge(array('response' => $productFinal), array('message' => $products['message']));

        return $finalArray;
    }


    public function get(int $prodId)
    {
        $products = $this->product->get((int)$prodId);

        if ($products['response'] == "false") {
            return $products;
        }

        foreach ($products['response'] as $product) {
            $product = (array)$product;
            $product['price_usd'] = number_format(($product['price'] / USD_ARS_EXCHANGE_PRICE), 2, ',', '.');
            $productFinal[] = $product;
        }

        $finalArray = array_merge(array('response' => $productFinal), array('message' => $products['message']));

        return $finalArray;
    }
}
