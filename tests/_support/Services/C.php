<?php

namespace Services;

use Sid\Container\Container;

class C extends \Sid\Container\Service
{
    public function getName() : string
    {
        return "c";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve(Container $container)
    {
        return $container->a . " " . $container->b;
    }
}
