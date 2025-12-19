<?php

trait DisplayTrait {
    
    public function displayProducts(array $products): void
    {
        if (empty($products)) {
            echo "No products found.\n";
            return;
        }

        echo str_repeat("=", 50) . "\n";
        foreach ($products as $product) {
            printf(
                " %-15s | R$ %8.2f | %s\n",
                $product->getName(),
                $product->getPrice(),
                $product->getCategory()
            );
        }
        echo str_repeat("=", 50) . "\n";
    }
}
