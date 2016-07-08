<?php

namespace Services;

use Sid\Container\Container;

class Hello extends \Sid\Container\Service
{
    public function getName() : string
    {
        return "hello";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve(Container $container)
    {
        return "hello";
    }
}
