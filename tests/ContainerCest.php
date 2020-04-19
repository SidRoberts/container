<?php

namespace Tests;

use Sid\Container\Container;
use Sid\Container\Exception\ServiceNotFoundException;
use Sid\Container\RawService;
use Sid\Container\Resolver;
use Tests\Services\HelloService;
use Tests\Services\IncrementerService;
use Tests\Services\InheritsHelloService;
use Tests\Services\ParameterService;
use Tests\Services\TypeHintedResolverService;

class ContainerCest
{
    public function testBasic(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new HelloService()
        );



        $I->assertEquals(
            "hello",
            $container->get("hello")
        );
    }



    public function testServiceDoesntExist(UnitTester $I)
    {
        $container = new Container();

        $I->expectThrowable(
            ServiceNotFoundException::class,
            function () use ($container) {
                $container->get("serviceThatDoesntExist");
            }
        );
    }



    public function testInheritance(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new HelloService()
        );

        $container->add(
            new InheritsHelloService()
        );



        $I->assertEquals(
            "hello",
            $container->get("hello")
        );

        $I->assertEquals(
            "hello",
            $container->get("inheritsHello")
        );
    }



    public function testServiceWithAParameter(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new ParameterService("Sid")
        );



        $I->assertEquals(
            "Hello Sid",
            $container->get("parameter")
        );
    }



    public function testHas(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new HelloService()
        );



        $I->assertTrue(
            $container->has("hello")
        );

        $I->assertFalse(
            $container->has("doesntExist")
        );
    }



    public function testSingleton(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new IncrementerService(false)
        );



        $I->assertEquals(
            0,
            $container->get("incrementer")->getI()
        );

        $container->get("incrementer")->increment();

        $I->assertEquals(
            0,
            $container->get("incrementer")->getI()
        );
    }



    public function testShared(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new IncrementerService(true)
        );



        $I->assertEquals(
            0,
            $container->get("incrementer")->getI()
        );

        $container->get("incrementer")->increment();

        $I->assertEquals(
            1,
            $container->get("incrementer")->getI()
        );
    }



    public function testRawService(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new RawService(
                "example",
                true,
                function (Container $container) {
                    return "hello";
                }
            )
        );



        $I->assertTrue(
            $container->has("example")
        );

        $I->assertEquals(
            "hello",
            $container->get("example")
        );
    }



    public function testTypeHintedResolver(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new TypeHintedResolverService()
        );

        $container->add(
            new ParameterService("Sid")
        );



        $I->assertEquals(
            "The 'parameter' service says: Hello Sid",
            $container->get("typeHintedResolver")
        );
    }



    public function testGetResolver(UnitTester $I)
    {
        $container = new Container();

        $resolver = $container->getResolver();

        $I->assertInstanceOf(
            Resolver::class,
            $resolver
        );
    }
}
