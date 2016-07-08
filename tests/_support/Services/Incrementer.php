<?php

namespace Services;

use Sid\Container\Container;

class Incrementer extends \Sid\Container\Service
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

    public function resolve(Container $container)
    {
        $incrementer = new \Incrementer();

        return $incrementer;
    }
}
