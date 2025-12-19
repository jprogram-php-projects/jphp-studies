<?php

require_once __DIR__. "/../traits/SoftDeletable.php";

class User
{
    use SoftDeletable;

    private string $email;
    private int $age;

    public function __construct(
        int $id,
        string $name,
        string $email,
        int $age
    ) {
        $this->email = $email;
        $this->age   = $age;
    }

    public function changeEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email inválido');
        }

        $this->email = $email;
    }

    public function isAdult(): bool
    {
        return $this->age >= 18;
    }
}
