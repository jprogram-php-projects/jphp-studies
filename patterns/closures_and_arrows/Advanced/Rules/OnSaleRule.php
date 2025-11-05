<?php

class OnSaleRule
{
    public function __construct(private int $minQty = 3) {}

    public function __invoke(array $item): bool
    {
        return $item['qty'] >= $this->minQty;
    }
}
