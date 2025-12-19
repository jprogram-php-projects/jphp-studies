<?php

class PremiumElectronicsRule
{
    public function __construct(
        private float $minPrice = 1000,
        private string $category = "electronics"
    ) {}

    public function __invoke(Product $p): bool
    {
        return $p->getCategory() === $this->category && $p->getPrice() > $this->minPrice;
    }
}
