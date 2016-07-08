<?php

namespace Sid\Container;

class RawService extends Service
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $isShared;

    /**
     * @var \Closure
     */
    protected $closure;



    public function __construct(string $name, bool $isShared, \Closure $closure)
    {
        $this->name     = $name;
        $this->isShared = $isShared;
        $this->closure  = $closure;
    }



    public function getName() : string
    {
        return $this->name;
    }

    public function isShared() : bool
    {
        return $this->isShared;
    }

    public function resolve(Container $container)
    {
        $closure = $this->closure;

        return $closure($container);
    }
}
