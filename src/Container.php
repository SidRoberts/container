<?php

namespace Sid\Container;

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



    public function get(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new ServiceNotFoundException($name);
        }



        if (isset($this->sharedServices[$name])) {
            return $this->sharedServices[$name];
        }

        $service = $this->services[$name];

        $resolvedService = $service->resolve($this);

        if ($service->isShared()) {
            $this->sharedServices[$name] = $resolvedService;
        }

        return $resolvedService;
    }



    public function add(Service $service) : self
    {
        $name = $service->getName();

        $this->services[$name] = $service;

        return $this;
    }



    public function has(string $name) : bool
    {
        return isset($this->services[$name]);
    }
}
