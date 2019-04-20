<?php

namespace Tests;

use Sid\Container\Container;

class ContainerCest
{
    public function testBasic(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new \Tests\Services\Hello()
        );



        $I->assertEquals(
            "hello",
            $container->get("hello")
        );
    }



    /**
     * @expectedException Sid\Container\Exception\ServiceNotFoundException
     */
    public function testServiceDoesntExist()
    {
        $container = new Container();

        $container->get("serviceThatDoesntExist");
    }



    public function testInheritance(UnitTester $I)
    {
        $container = new Container();

        $container->add(
            new \Tests\Services\Hello()
        );

        $container->add(
            new \Tests\Services\InheritsHello()
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
            new \Tests\Services\Parameter("Sid")
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
            new \Tests\Services\Hello()
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
            new \Tests\Services\Incrementer(false)
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
            new \Tests\Services\Incrementer(true)
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
            new \Sid\Container\RawService(
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
            new \Tests\Services\TypeHintedResolver()
        );

        $container->add(
            new \Tests\Services\Parameter("Sid")
        );



        $I->assertEquals(
            "The 'parameter' service says: Hello Sid",
            $container->get("typeHintedResolver")
        );
    }
}
