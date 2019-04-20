<?php

namespace Tests\Services;

use Sid\Container\Container;
use Sid\Container\Service;

class ParameterService extends Service
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

    public function resolve()
    {
        return "Hello " . $this->name;
    }
}
