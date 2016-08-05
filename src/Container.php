<?php

namespace Sid\Container;

use ReflectionMethod;

use Sid\Container\Exception\ServiceNotFoundException;

class Container
{
    /**
     * @var array
     */
    protected $services = [];

    /**
     * @var array
     */
    protected $sharedServices = [];



    public function __get(string $name)
    {
        if (!$this->has($name)) {
            return null;
        }

        return $this->get($name);
    }

    public function __set(string $name, $value)
    {
        $this->set($name, $value);
    }



    public function get(string $name)
    {
        if (isset($this->sharedServices[$name])) {
            return $this->sharedServices[$name];
        }

        if (!isset($this->services[$name])) {
            throw new ServiceNotFoundException($name);
        }



        $service = $this->services[$name];

        $resolvedService = $this->typehintService($service);

        if ($service->isShared()) {
            $this->sharedServices[$name] = $resolvedService;
        }

        return $resolvedService;
    }

    public function set(string $name, $value)
    {
        $this->sharedServices[$name] = $value;
    }



    public function add(Service $service) : self
    {
        $name = $service->getName();

        $this->services[$name] = $service;

        return $this;
    }



    public function has(string $name) : bool
    {
        return isset($this->services[$name]) || isset($this->sharedServices[$name]);
    }



    public function typehintService(Service $service)
    {
        $serviceClass = get_class($service);

        $reflectionMethod = new ReflectionMethod($serviceClass, "resolve");

        $reflectionParameters = $reflectionMethod->getParameters();

        $params = [];

        foreach ($reflectionParameters as $reflectionParameter) {
            $serviceName = $reflectionParameter->getName();

            if ($serviceName === "container") {
                $paramService = $this;
            } else {
                $paramService = $this->get($serviceName);
            }

            $params[] = $paramService;
        }

        return call_user_func_array(
            [
                $service,
                "resolve"
            ],
            $params
        );
    }
}
