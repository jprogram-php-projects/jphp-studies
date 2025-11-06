# Estudo PHP: Closures e Arrow Functions

![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)
![Status](https://img.shields.io/badge/Challenge-Daily-green)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

---

## 🎨 Desafio do Dia

**Tecnologia/Conceito:** Closures (funções anônimas com `use`) + Arrow Functions (`fn`) em PHP 8

**Propósito:** Aprender a criar funções dinâmicas e expressivas, aplicando conceitos de programação funcional moderna no PHP.

**Por que é útil?**

Closures permitem encapsular comportamento e estado, tornando o código mais reutilizável e modular. São essenciais em frameworks como **Laravel**, por exemplo em **middlewares, filas, eventos e manipulação de coleções**.

As **Arrow Functions** (`fn`) introduzidas no PHP 7.4 simplificam a sintaxe e tornam callbacks mais legíveis.

Dominar esses conceitos é um passo importante para sair do estilo procedural e abraçar o **PHP moderno e funcional**.

---

## 🖊️ Teoria Resumida

### **Closure**

É uma função anônima que pode **capturar variáveis do escopo externo** usando a palavra-chave `use`.

### **Arrow Function (`fn`)**

Sintaxe curta para funções anônimas, que **herda automaticamente variáveis** do escopo pai (dispensa `use`).

| Característica       | Closure (`function`)   | Arrow (`fn`)         |
| -------------------- | ---------------------- | -------------------- |
| Captura de variáveis | Precisa de `use($var)` | Automática           |
| Corpo da função      | Múltiplas linhas       | Apenas uma expressão |
| Suporte a `$this`    | Sim                    | Não                  |

**Resumo prático:**

> Use **arrow functions** para callbacks simples e **closures completas** quando precisar de lógica mais elaborada ou acesso a `$this`.

---

## 👨‍💼 Exemplo de Código

Abaixo, um exemplo de **sistema de descontos dinâmicos** usando closures e arrow functions:

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
$cart->add(new Product("Camiseta", 79.90, "roupas"), 2);
$cart->add(new Product("Notebook", 3500.00, "eletrônicos"), 1);

// Closure tradicional com use
$blackFridayDiscount = function (Product $product, int $quantity) use ($cart) {
    $basePrice = $product->price;
    if ($product->category === 'eletrônicos') {
        return $basePrice * 0.75; // 25% off
    }
    if ($quantity >= 2) {
        return $basePrice * 0.90; // 10% off
    }
    return $basePrice;
};

// Arrow function simples
$clearanceSale = fn(Product $product, int $quantity) =>
    $product->price * ($product->category === 'roupas' ? 0.5 : 0.9);

echo "Black Friday: R$ " . $cart->applyDiscount($blackFridayDiscount) . PHP_EOL;
echo "Liquidação: R$ " . $cart->applyDiscount($clearanceSale) . PHP_EOL;
```

**Saída esperada:**

```
Black Friday: R$ 2717.70
Liquidação: R$ 3239.50
```

### Explicação resumida

* `Closure $discountRule`: o parâmetro aceita qualquer função anônima.
* `use ($cart)`: captura variáveis externas (opcional neste exemplo).
* `fn(...) => ...`: arrow function de uma linha.
* `$discountRule($product, $quantity)`: executa o comportamento dinâmico.

---

## 🔧 Boas Práticas

* Use `fn` em callbacks simples (`array_map`, `array_filter`, etc.).
* Use closures completas para lógicas complexas ou acesso a `$this`.
* Evite capturar objetos grandes com `use` (risco de vazamento de memória).
* Sempre tipar argumentos e retornos (`function(Product $p): float`).
* **Laravel tip:** use closures em rotas e middlewares de forma legível:

```php
Route::get('/admin', fn() => auth()->user()?->isAdmin() ? view('admin') : abort(403));
```

---

## 🏆 Desafio do Dia

Crie um **sistema de filtros dinâmicos** para produtos.

### Regras:

1. Crie uma classe `ProductFilter` com o método:

```php
public function filter(array $products, Closure $rule): array
```

Retorna apenas os produtos que passam na regra.

2. Crie três filtros diferentes:

* `cheapProducts`: preço < 100
* `premiumElectronics`: eletrônicos com preço > 1000
* `onSale`: desconto de 20% se quantidade ≥ 3

3. Use:

* **1 arrow function**
* **2 closures com use**

### Exemplo de uso:

```php
$products = [
    new Product("Fone", 89.90, "eletrônicos"),
    new Product("TV 4K", 2799.00, "eletrônicos"),
    new Product("Meia", 12.50, "roupas"),
];

$filter = new ProductFilter();

$cheap = $filter->filter($products, $cheapProductsRule);
print_r($cheap);
```

### Variação Avançada (opcional)

Transforme o `ProductFilter` em um **pipeline** que permita encadear várias regras:

```php
$result = (new ProductFilter)
    ->add($rule1)
    ->add($rule2)
    ->run($products);
```

Use **traits** ou **classes invocáveis** (`__invoke`) para regras reutilizáveis.

---

> Este estudo faz parte da série *PHP Moderno na Prática*, explorando recursos avançados da linguagem de forma aplicada e incremental.
