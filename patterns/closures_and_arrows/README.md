# PHP Study: Closures and Arrow Functions
[🇧🇷 Leia em Português](./README.pt-BR.md)

![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)
![Status](https://img.shields.io/badge/Challenge-Daily-green)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

---

## 🎨 Daily Challenge

**Technology/Concept:** Closures (anonymous functions with `use`) + Arrow Functions (`fn`) in PHP 8

**Purpose:** Learn how to create dynamic and expressive functions by applying modern functional programming concepts in PHP.

**Why is it useful?**

Closures allow encapsulating behavior and state, making code more reusable and modular. They are essential in frameworks like **Laravel**, for example in **middlewares, queues, events, and collection manipulation**.

**Arrow Functions** (`fn`) introduced in PHP 7.4 simplify syntax and make callbacks more readable.
Mastering these concepts is a big step from procedural PHP to **modern functional PHP**.

---

## 🖊️ Summary Theory

### **Closure**

An anonymous function that can **capture variables from the outer scope** using the `use` keyword.

### **Arrow Function (`fn`)**

A short syntax for anonymous functions that **automatically inherits variables** from the parent scope (no need for `use`).

| Feature          | Closure (`function`) | Arrow (`fn`)      |
| ---------------- | -------------------- | ----------------- |
| Variable capture | Requires `use($var)` | Automatic         |
| Function body    | Multiple lines       | Single expression |
| Supports `$this` | Yes                  | No                |

**Quick summary:**

> Use **arrow functions** for simple callbacks, and **full closures** when you need more complex logic or access to `$this`.

---

## 👨‍💼 Code Example

Below is an example of a **dynamic discount system** using closures and arrow functions:

```php
<?php

class Product
{
    public function __construct(
        public string $name,
        public float $price,
        public string $category
    ) {}
}

class Cart
{
    private array $items = [];

    public function add(Product $product, int $quantity = 1): void
    {
        $this->items[] = ['product' => $product, 'quantity' => $quantity];
    }

    public function applyDiscount(Closure $discountRule): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            $discountedPrice = $discountRule($product, $quantity);
            $total += $discountedPrice * $quantity;
        }
        return $total;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}

$cart = new Cart();
$cart->add(new Product("T-shirt", 79.90, "clothing"), 2);
$cart->add(new Product("Laptop", 3500.00, "electronics"), 1);

// Traditional closure with use
$blackFridayDiscount = function (Product $product, int $quantity) use ($cart) {
    $basePrice = $product->price;
    if ($product->category === 'electronics') {
        return $basePrice * 0.75; // 25% off
    }
    if ($quantity >= 2) {
        return $basePrice * 0.90; // 10% off for bulk
    }
    return $basePrice;
};

// Simple arrow function
$clearanceSale = fn(Product $product, int $quantity) =>
    $product->price * ($product->category === 'clothing' ? 0.5 : 0.9);

echo "Black Friday: $" . $cart->applyDiscount($blackFridayDiscount) . PHP_EOL;
echo "Clearance: $" . $cart->applyDiscount($clearanceSale) . PHP_EOL;
```

**Expected output:**

```
Black Friday: $2717.70
Clearance: $3239.50
```

### Line-by-line explanation

* `Closure $discountRule`: the parameter accepts any anonymous function.
* `use ($cart)`: captures external variables (optional in this example).
* `fn(...) => ...`: one-line arrow function.
* `$discountRule($product, $quantity)`: executes the dynamic behavior.

---

## 🔧 Best Practices

* Use `fn` for simple callbacks (`array_map`, `array_filter`, etc.).
* Use full closures for complex logic or `$this` references.
* Avoid capturing large objects with `use` (memory leaks risk).
* Always type arguments and return values (`function(Product $p): float`).
* **Laravel tip:** use closures in routes and middleware, but keep them readable:

```php
Route::get('/admin', fn() => auth()->user()?->isAdmin() ? view('admin') : abort(403));
```

---

## 🏆 Daily Challenge

Build a **dynamic product filter system**.

### Requirements:

1. Create a `ProductFilter` class with a method:

```php
public function filter(array $products, Closure $rule): array
```

Returns only the products that pass the rule.

2. Create three different filters:

* `cheapProducts`: price < 100
* `premiumElectronics`: electronics with price > 1000
* `onSale`: 20% discount if quantity ≥ 3

3. Use:

* **1 arrow function**
* **2 closures with use**

### Example usage:

```php
$products = [
    new Product("Headphones", 89.90, "electronics"),
    new Product("4K TV", 2799.00, "electronics"),
    new Product("Socks", 12.50, "clothing"),
];

$filter = new ProductFilter();

$cheap = $filter->filter($products, $cheapProductsRule);
print_r($cheap);
```

### Advanced Variation (optional)

Transform `ProductFilter` into a **pipeline** that allows chaining multiple rules:

```php
$result = (new ProductFilter)
    ->add($rule1)
    ->add($rule2)
    ->run($products);
```

Use **traits** or **invokable classes** (`__invoke`) for reusable rules.

---

> This study is part of the *Modern PHP in Practice* series, exploring advanced language features through practical, hands-on exercises.
