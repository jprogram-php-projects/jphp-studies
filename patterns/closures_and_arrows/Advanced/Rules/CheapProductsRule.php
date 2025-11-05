<?php

class CheapProductsRule
{
    public function __invoke(Product $p): bool
    {
        return $p->getPrice() < 100;
    }
}
