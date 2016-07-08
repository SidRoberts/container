<?php

namespace Services;

use Sid\Container\Container;

class B extends \Sid\Container\Service
{
    public function getName() : string
    {
        return "b";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve(Container $container)
    {
        return $container->a;
    }
}
