<?php

namespace Tests\Services;

use Sid\Container\Service;

class HelloService extends Service
{
    public function getName() : string
    {
        return "hello";
    }

    public function isShared() : bool
    {
        return true;
    }

    public function resolve()
    {
        return "hello";
    }
}
