<?php

namespace Services;

use Sid\Container\Container;

class InheritsHello extends \Sid\Container\Service
{
    public function getName() : string
    {
        return "inheritsHello";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve(Container $container)
    {
        return $container->hello;
    }
}
