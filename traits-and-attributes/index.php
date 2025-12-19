<?php

// Solution to Exercise 1.
// Exercise 1 - Create an attribute #[Route(string $path)] and a trait Routable that lists all the routes of the class.

require_once './controller/RouteController.php';

$routeController = new RouteController();
$routeController->collectRoutes();

echo "\n============= SOLUTION (EXERCISE 1) =============\n\n";

foreach ($routeController->getRoutes() as $route) {
    echo "- {$route['path']} ({$route['method']})\n";
}

// Solution to Exercise 2.
// Exercise 2 - Create a SoftDeletable trait with deletedAt and a delete() method that only marks it as deleted.

require_once "./model/User.php";

echo "\n============= SOLUTION (EXERCISE 2) =============\n\n";

$user = new User(1, "Jefferson", "jeff@test.com", 20, date("Y-m-d H:i:s"), date("Y-m-d H:i:s"));

echo "User deleted? ", ( $user->isDeleted() ? 'true' : 'false' ). "\n";

$user->delete();

echo "User deleted? ", ( $user->isDeleted() ? "true ( {$user->getDeletedAt()} )" : 'false' ). "\n";


// Solution to Exercise 3.
// Exercise 3 - Create an attribute #[MaxLength(int $value)] and add it to the validation trait.

require_once './DTO/UserDTO.php';

$user = new UserDTO();

$errors = $user->validate([
    'email' => 'email_muito_grande_com_erro@dominio.com.br',
    'name'  => 'NomeMuitoGrandeQueUltrapassaOLimite'
]);

echo "\n============= SOLUTION (EXERCISE 3) =============\n\n";

print_r($errors);
