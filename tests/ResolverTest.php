<?php

namespace Sid\Container\Tests\Unit;

use Codeception\TestCase\Test;
use Sid\Container\Container;
use Sid\Container\Resolver;

class ResolverTest extends Test
{
    public function testTypehintClass()
    {
        $container = new Container();

        $container->add(
            new \Services\Hello()
        );

        $container->add(
            new \Services\Parameter("Sid")
        );

        $container->add(
            new \Services\Incrementer(true)
        );



        $resolver = new Resolver($container);



        $typehintedClass = $resolver->typehintClass(
            \ResolvableClass::class
        );



        $this->assertEquals(
            "hello",
            $typehintedClass->hello
        );

        $this->assertEquals(
            "Hello Sid",
            $typehintedClass->parameter
        );

        $this->assertEquals(
            0,
            $typehintedClass->incrementer->getI()
        );
    }
}
