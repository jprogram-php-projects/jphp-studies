<?php

class Product {

    private string $name;
    private float  $price;
    private string $category;

    public function __construct(
        string $name,
        float  $price,
        string $category
    ) {
        $this->name     = $name;
        $this->price    = $price;
        $this->category = $category;
    }

    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getCategory(): string { return $this->category; }

    public function setPrice(float $p): void { $this->price = $p; }

    // public function __toString(): string {
    //     return sprintf(
    //         "Product{name: '%s', price: R$ %.2f, category: '%s'}",
    //         $this->name,
    //         $this->price,
    //         $this->category
    //     );
    // }
}