# Estudo Avançado em PHP: Filtro de Produtos com Pipeline, Traits e Classes Invocáveis

## 🚀 Visão Geral do Desafio Avançado

Esta é a **versão avançada (opcional)** do estudo anterior sobre **Closures e Funções Arrow em PHP**. Nesta etapa, o objetivo é evoluir o conceito de `ProductFilter`, transformando-o em um **Sistema de Pipeline**, que permite **encadear múltiplas regras de filtro** de forma limpa, reutilizável e flexível.

---

## 🧠 Conceitos Envolvidos

### **1. Padrão Pipeline**

O **Pipeline** é um padrão de design em que um dado passa por uma sequência de estágios de processamento (ou filtros), onde cada um transforma ou valida a informação antes de repassá-la ao próximo.

Em PHP, isso pode ser implementado de forma elegante com **Closures**, **classes invocáveis** ou **Traits** para reaproveitamento de código.

**Fluxo de exemplo:**

```php
$result = (new ProductFilter)
    ->add($rule1)
    ->add($rule2)
    ->run($products);
```

Cada regra adicionada atua como uma etapa no pipeline, permitindo combinar múltiplas condições dinamicamente.

---

### **2. Traits**

**Traits** são um mecanismo do PHP para **reutilizar código entre classes**. Elas permitem incluir métodos e propriedades sem necessidade de herança.

**Exemplo:**

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

Uma classe pode usar múltiplas traits:

```php
class ProductFilter {
    use PriceRules, CategoryRules;
}
```

Isso mantém as regras modulares e reutilizáveis em diferentes contextos.

---

### **3. Classes Invocáveis**

Uma **classe invocável** é uma classe que implementa o método especial `__invoke()`, permitindo que suas instâncias sejam chamadas como se fossem funções.

Essa técnica é ideal para criar **regras de filtro autocontidas**, que encapsulam lógica e podem ser reutilizadas de forma independente.

**Exemplo:**

```php
class CheapProductRule {
    public function __invoke(Product $product): bool
    {
        return $product->price < 100;
    }
}

$cheapRule = new CheapProductRule();

if ($cheapRule($product)) {
    echo "Este é um produto barato.";
}
```

---

## ⚙️ Exemplo de Implementação

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

// Exemplo de uso
$pipeline = (new ProductFilter)
    ->add(fn($p) => $p->price > 50)
    ->add(new CheapProductRule())
    ->run($products);
```

**Explicação:**

* `add(callable $rule)`: aceita uma Closure, função arrow ou classe invocável.
* `run()`: executa cada regra em sequência, filtrando a lista progressivamente.

---

## 🧩 Por Que Essa Abordagem É Importante

Ao combinar **Pipelines**, **Traits** e **Classes Invocáveis**, você obtém:

* **Separação de responsabilidades** — cada regra tem um único propósito.
* **Reutilização** — regras podem ser aplicadas em diferentes partes do sistema.
* **Composição** — filtros podem ser encadeados em diferentes ordens.
* **Flexibilidade** — suporta closures, funções arrow e objetos invocáveis de forma unificada.

---

## 🏁 Conclusão

Esta versão avançada transforma um simples sistema de filtros em uma **arquitetura poderosa e extensível**, aplicando princípios de **programação orientada a objetos e funcional** em PHP.

É um excelente exemplo de como **Closures**, **Traits** e **Classes Invocáveis** podem trabalhar juntas para criar um código limpo, expressivo e moderno em PHP.
