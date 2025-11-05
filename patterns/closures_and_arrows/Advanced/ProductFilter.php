<?php

require_once './Traits/DisplayTrait.php';

class ProductFilter
{
    use DisplayTrait;

    private array $rules = [];

    public function add(callable $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function run(array $products): array
    {
        $filtered = $products;

        foreach ($this->rules as $rule) {
            $filtered = array_filter($filtered, $rule);
        }

        return $filtered;
    }
}
