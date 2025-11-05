<?php

require_once '../Product.php';
require_once './ProductFilter.php';
require_once './Rules/CheapProductsRule.php';
require_once './Rules/PremiumElectronicsRule.php';
require_once './Rules/OnSaleRule.php';

$products = [
    ['product' => new Product("Fone" , 89.90  , "electronics"), 'qty' => 1],
    ['product' => new Product("TV 4K", 2799.00, "electronics"), 'qty' => 1],
    ['product' => new Product("Meia" , 12.50  , "clothes"    ), 'qty' => 5],
    ['product' => new Product("Mouse", 150.00 , "electronics"), 'qty' => 3]
];

// Mapping only the Product objects
$allProducts = array_map(fn($item) => $item['product'], $products);

// Simple pipeline with invokable and closure
echo "=== CHEAP PRODUCTS ===\n";
$result = (new ProductFilter)
    ->add(new CheapProductsRule)
    ->run($allProducts);
(new ProductFilter)->displayProducts($result);

// Chaining multiple filters
echo "\n=== PREMIUM ELECTRONICS ===\n";
$result = (new ProductFilter)
    ->add(new PremiumElectronicsRule(1000))
    ->add(fn($p) => $p->getCategory() === 'electronics')
    ->run($allProducts);
(new ProductFilter)->displayProducts($result);


echo "\n=== ON OFFER (qty >= 3) ===\n";
$onSale = (new ProductFilter)
    ->add(new OnSaleRule(3))
    ->run($products);
$onSaleProducts = array_map(fn($item) => $item['product'], $onSale);
(new ProductFilter)->displayProducts($onSaleProducts);
