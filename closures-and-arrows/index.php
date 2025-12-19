<?php

require_once './Product.php';
require_once './ProductFilter.php';

// 1️⃣ ARROW FUNCTION (cheapProducts)
$cheapProducts = fn(Product $p): bool => $p->getPrice() < 100;

// 2️⃣ CLOSURE COM USE (premiumElectronics)
$minPrice = 1000;
$category = "electronics";

$premiumElectronics = function(Product $p) use ($minPrice, $category): bool {
    return $p->getCategory() === $category && $p->getPrice() > $minPrice;
};

// 3️⃣ CLOSURE COM USE (onSale)
$minQuantity = 3;
$onSaleRule = function(array $item) use ($minQuantity): bool {
    return $item['qty'] >= $minQuantity;
};

$products = [
    ['product' => new Product("Fone" , 89.90  , "electronics"), 'qty' => 1],
    ['product' => new Product("TV 4K", 2799.00, "electronics"), 'qty' => 1],
    ['product' => new Product("Meia" , 12.50  , "clothes"    ), 'qty' => 5],
    ['product' => new Product("Mouse", 150.00 , "electronics"), 'qty' => 3]
];

$filter = new ProductFilter();

echo "=== CHEAP PRODUCTS (price < 100) ===\n";
$allProducts = array_map(fn($item) => $item['product'], $products);
$cheap = $filter->filter($allProducts, $cheapProducts);
$filter->displayProducts($cheap);


echo "\n=== PREMIUM ELECTRONICS (electronics + price > 1000) ===\n";
$premium = $filter->filter($allProducts, $premiumElectronics);
$filter->displayProducts($premium);


echo "\n=== ON OFFER (qty >= 3) ===\n";
$onSale = array_filter($products, $onSaleRule);
$onSaleProducts = array_map(fn($item) => $item['product'], $onSale);
$filter->displayProducts($onSaleProducts);