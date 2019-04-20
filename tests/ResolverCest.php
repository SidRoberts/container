<?php

namespace Tests;

use Sid\Container\Container;
use Sid\Container\Resolver;

class ResolverCest
{
    public function testTypehintClass(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new \Tests\Services\Hello()
        );

        $container->add(
            new \Tests\Services\Parameter("Sid")
        );

        $container->add(
            new \Tests\Services\Incrementer(true)
        );



        $resolver = new Resolver($container);



        $typehintedClass = $resolver->typehintClass(
            \Tests\ResolvableClass::class
        );



        $I->assertEquals(
            "hello",
            $typehintedClass->hello
        );

        $I->assertEquals(
            "Hello Sid",
            $typehintedClass->parameter
        );

        $I->assertEquals(
            0,
            $typehintedClass->incrementer->getI()
        );
    }
}
