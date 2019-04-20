<?php

namespace Tests\Services;

use Sid\Container\Container;
use Sid\Container\Service;

class InheritsHello extends Service
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
