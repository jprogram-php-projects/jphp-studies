<?php

require_once './Product.php';

class ProductFilter {

    public function filter(array $products, Closure $rule): array {
        return array_filter($products, $rule);
    }

    public function displayProducts(array $products): void {

        if (empty($products)) {
            echo "No products found.\n";
            return;
        }

        echo str_repeat("=", 50) . "\n";
        foreach ($products as $product) {
            printf(" %-15s | R$ %8.2f | %s\n",
                $product->getName(),
                $product->getPrice(),
                $product->getCategory()
            );
        }
        echo str_repeat("=", 50) . "\n";
    }
}

// 1️⃣ ARROW FUNCTION (cheapProducts)
$cheapProducts = fn(Product $p): bool => $p->getPrice() < 100;

// 2️⃣ CLOSURE COM USE (premiumElectronics)
$minPrice = 1000;
$category = "eletrônicos";

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

echo "=== PRODUTOS BARATOS (preço < 100) ===\n";
$allProducts = array_map(fn($item) => $item['product'], $products);
$cheap = $filter->filter($allProducts, $cheapProducts);
$filter->displayProducts($cheap);

echo "\n=== ELETRÔNICOS PREMIUM (eletrônicos + preço > 1000) ===\n";
$premium = $filter->filter($allProducts, $premiumElectronics);
$filter->displayProducts($premium);

echo "\n=== EM OFERTA (qty >= 3) ===\n";
$onSale = array_filter($products, $onSaleRule);
$onSaleProducts = array_map(fn($item) => $item['product'], $onSale);
$filter->displayProducts($onSaleProducts);