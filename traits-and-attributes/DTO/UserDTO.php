<?php

require_once __DIR__. "/../traits/Validade.php";

class UserDTO
{
    use ValidatesAttributes;

    #[Required]
    #[MaxLength(30)]
    public string $name;

    #[Required]
    #[Email]
    #[MaxLength(20)]
    public string $email;

    #[Required]
    public int $age;
}
