<?php

require_once __DIR__. '/../traits/Routable.php';

class RouteController
{
    use Routable;

    #[Route("GET", "/")]
    public function home(){ }

    #[Route("POST", "/login")]
    public function login(){ }

    #[Route("POST","/logout")]
    public function logout(){ }

    #[Route("DELETE", "/user/delete")]
    public function delete($user) : bool
    { 
        $user->delete();
        return $user->isDeleted();
    }

}
