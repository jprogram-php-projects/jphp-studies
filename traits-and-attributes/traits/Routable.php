<?php

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        private string $method,
        private string $path
    ) { }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getMethod() : string
    {
        return $this->method;
    }
}

trait Routable
{
    private array $listRoutes = [];

    public function collectRoutes() : void
    {
        $reflection = new ReflectionClass($this);

        foreach ($reflection->getMethods() as $method) {
            $attributes = $method->getAttributes(Route::class);

            foreach ($attributes as $att) {
                $route = $att->newInstance();
                
                $this->listRoutes[] = [
                    "method" => $route->getMethod(),
                    "path"   => $route->getPath()
                ];
            }
        }
    }

    public function getRoutes() : array
    {
        return $this->listRoutes;
    }

}
