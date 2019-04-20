<?php

namespace Tests;

use Sid\Container\Container;
use Sid\Container\Resolver;
use Tests\ResolvableClass;
use Tests\Services\HelloService;
use Tests\Services\IncrementerService;
use Tests\Services\ParameterService;

class ResolverCest
{
    public function testTypehintClass(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new HelloService()
        );

        $container->add(
            new ParameterService("Sid")
        );

        $container->add(
            new IncrementerService(true)
        );



        $resolver = new Resolver($container);



        $typehintedClass = $resolver->typehintClass(
            ResolvableClass::class
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
