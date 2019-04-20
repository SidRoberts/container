<?php

namespace Tests\Services;

use Sid\Container\Container;
use Sid\Container\Service;

class IncrementerService extends Service
{
    protected $isShared;



    public function __construct(bool $isShared)
    {
        $this->isShared = $isShared;
    }



    public function getName() : string
    {
        return "incrementer";
    }

    public function isShared() : bool
    {
        return $this->isShared;
    }

    public function resolve()
    {
        $incrementer = new \Tests\Incrementer();

        return $incrementer;
    }
}
