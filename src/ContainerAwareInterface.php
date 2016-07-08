<?php

namespace Sid\Container;

interface ContainerAwareInterface
{
    public function __construct(Container $container);
}
