<?php

namespace Services;

use Sid\Container\Container;

class Parameter extends \Sid\Container\Service
{
    protected $name;



    public function __construct(string $name)
    {
        $this->name = $name;
    }



    public function getName() : string
    {
        return "parameter";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve(Container $container)
    {
        return "Hello " . $this->name;
    }
}
