<?php

namespace Tests\Services;

use Sid\Container\Service;

class InheritsHelloService extends Service
{
    public function getName() : string
    {
        return "inheritsHello";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve($hello)
    {
        return $hello;
    }
}
