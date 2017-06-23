<?php

namespace Sid\Container;

use ReflectionClass;
use ReflectionMethod;

class Resolver
{
    /**
     * @var Container
     */
    protected $container;



    public function __construct(Container $container)
    {
        $this->container = $container;
    }



    public function typehintClass(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->hasMethod("__construct")) {
            return $reflectionClass->newInstance();
        }

        $reflectionMethod = $reflectionClass->getMethod("__construct");

        $params = $this->resolveParams($reflectionMethod);

        return $reflectionClass->newInstanceArgs($params);
    }



    public function typehintMethod($class, string $method)
    {
        $className = get_class($class);

        $reflectionMethod = new ReflectionMethod($className, $method);

        $params = $this->resolveParams($reflectionMethod);

        return call_user_func_array(
            [
                $class,
                $method
            ],
            $params
        );
    }



    public function typehintService(Service $service)
    {
        return $this->typehintMethod($service, "resolve");
    }



    protected function resolveParams(ReflectionMethod $reflectionMethod)
    {
        $reflectionParameters = $reflectionMethod->getParameters();

        $params = [];

        foreach ($reflectionParameters as $reflectionParameter) {
            $serviceName = $reflectionParameter->getName();

            if ($serviceName === "container") {
                $paramService = $this->container;
            } else {
                $paramService = $this->container->get($serviceName);
            }

            $params[] = $paramService;
        }

        return $params;
    }
}
