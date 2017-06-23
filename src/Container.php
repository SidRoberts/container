<?php

namespace Sid\Container;

use ReflectionClass;
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

    /**
     * @var Resolver
     */
    protected $resolver;



    public function __construct()
    {
        $this->resolver = new Resolver($this);
    }



    public function getResolver() : Resolver
    {
        return $this->resolver;
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

        $resolvedService = $this->resolver->typehintService($service);

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
}
