# PHP Advanced Study: Product Filter Pipeline with Traits and Invokable Classes
[🇧🇷 Leia em Português](./README.pt-br.md)

---

## 🚀 Advanced Challenge Overview

This is the **advanced (optional) version** of the previous PHP study about **Closures and Arrow Functions**. In this version, the goal is to take the `ProductFilter` concept further by transforming it into a **Pipeline System** that allows chaining multiple filtering rules in a clean, reusable, and flexible way.

---

## 🧠 Concepts Involved

### **1. Pipeline Pattern**

A **Pipeline** is a design pattern where a piece of data passes through a sequence of processing stages (or filters), each of which transforms or validates the data before passing it to the next.

In PHP, this can be elegantly implemented using **Closures**, **invokable classes**, or even **Traits** for code reuse.

**Example flow:**

```php
$result = (new ProductFilter)
    ->add($rule1)
    ->add($rule2)
    ->run($products);
```

Each added rule acts as a stage in the pipeline, allowing you to combine multiple conditions dynamically.

---

### **2. Traits**

**Traits** are a PHP mechanism for reusing code across multiple classes. They allow you to include methods or properties without using inheritance.

**Example:**

```php
trait PriceRules {
    public function cheapProducts(Product $product): bool
    {
        return $product->price < 100;
    }

    public function premiumElectronics(Product $product): bool
    {
        return $product->category === 'electronics' && $product->price > 1000;
    }
}
```

A class can then use multiple traits:

```php
class ProductFilter {
    use PriceRules, CategoryRules;
}
```

This keeps rules modular and reusable across different contexts.

---

### **3. Invokable Classes**

An **invokable class** is a class that implements the special `__invoke()` method, allowing its instances to be used as if they were functions.

This is perfect for creating **self-contained filter rules** that encapsulate logic and can be reused independently.

**Example:**

```php
class CheapProductRule {
    public function __invoke(Product $product): bool
    {
        return $product->price < 100;
    }
}

$cheapRule = new CheapProductRule();

if ($cheapRule($product)) {
    echo "This is a cheap product.";
}
```

---

## ⚙️ Implementation Example

```php
class ProductFilter
{
    private array $rules = [];

    public function add(callable $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function run(array $products): array
    {
        foreach ($this->rules as $rule) {
            $products = array_filter($products, $rule);
        }
        return $products;
    }
}

// Example usage
$pipeline = (new ProductFilter)
    ->add(fn($p) => $p->price > 50)
    ->add(new CheapProductRule())
    ->run($products);
```

**Explanation:**

* `add(callable $rule)`: accepts either a Closure, arrow function, or invokable class.
* `run()`: executes each rule in sequence, filtering the list progressively.

---

## 🧩 Why This Approach Matters

By combining **Pipelines**, **Traits**, and **Invokable Classes**, you achieve:

* **Separation of concerns** — each rule has a single responsibility.
* **Reusability** — rules can be shared across different parts of the codebase.
* **Composability** — filters can be dynamically chained in different orders.
* **Flexibility** — supports closures, arrow functions, or invokable objects seamlessly.

---

## 🏁 Conclusion

This advanced version transforms a simple filtering system into a **powerful and extensible architecture**, applying object-oriented and functional programming principles in PHP.

It’s a great example of how **Closures**, **Traits**, and **invokable classes** can work together to create clean, expressive, and modern PHP code.
