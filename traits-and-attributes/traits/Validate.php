<?php

#[Attribute(Attribute::TARGET_PROPERTY)]
class MaxLength
{
    public function __construct(
        public int $value,
        public ?string $message = null
    ) {}
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required
{
    public function __construct(public ?string $message = null) {}
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class Email
{
    public function __construct(public ?string $message = null) {}
}


trait ValidatesAttributes
{
    public function validate(array $data): array
    {
        $errors = [];
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {

            $field = $property->getName();
            $value = $data[$field] ?? null;

            foreach ($property->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                $error = $this->validateAttribute($instance, $value, $field);

                if ($error !== null) {
                    $errors[$field] = $error;
                }
            }
        }

        return $errors;
    }

    private function validateAttribute(object $attribute, mixed $value, string $field): ?string
    {
        return match (true) {

            $attribute instanceof Required =>
                empty($value)
                    ? $attribute->message ?? "O campo {$field} é obrigatório"
                    : null,

            $attribute instanceof Email =>
                !filter_var($value, FILTER_VALIDATE_EMAIL)
                    ? $attribute->message ?? "O campo {$field} deve ser um e-mail válido"
                    : null,

            $attribute instanceof MaxLength =>
                is_string($value) && strlen($value) > $attribute->value
                    ? $attribute->message ?? "O campo {$field} deve ter no máximo {$attribute->value} caracteres"
                    : null,

            default => null
        };
    }
}
