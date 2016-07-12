<?php

namespace Sid\Container\Tests\Unit;

use Sid\Container\Container;

class ContainerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }



    public function testBasic()
    {
        $container = new Container();

        $container->add(
            new \Services\Hello()
        );



        $this->assertEquals(
            "hello",
            $container->hello
        );



        $this->assertEquals(
            "hello",
            $container->get("hello")
        );
    }



    public function testServiceDoesntExist()
    {
        $container = new Container();



        $this->assertNull(
            $container->serviceThatDoesntExist
        );



        try {
            $container->get("serviceThatDoesntExist");

            $this->assertTrue(false);
        } catch (\Sid\Container\Exception\ServiceNotFoundException $e) {
            $this->assertTrue(true);
        }
    }



    public function testInheritance()
    {
        $container = new Container();

        $container->add(
            new \Services\Hello()
        );

        $container->add(
            new \Services\InheritsHello()
        );



        $this->assertEquals(
            "hello",
            $container->hello
        );

        $this->assertEquals(
            "hello",
            $container->inheritsHello
        );
    }



    public function testServiceWithAParameter()
    {
        $container = new Container();

        $container->add(
            new \Services\Parameter("Sid")
        );



        $this->assertEquals(
            "Hello Sid",
            $container->parameter
        );
    }



    public function testHas()
    {
        $container = new Container();

        $container->add(
            new \Services\Hello()
        );



        $this->assertTrue(
            $container->has("hello")
        );

        $this->assertFalse(
            $container->has("doesntExist")
        );
    }



    public function testNonexistentPropertyReturnsNull()
    {
        $container = new Container();

        $this->assertNull(
            $container->doesntExist
        );
    }



    public function testSingleton()
    {
        $container = new Container();

        $container->add(
            new \Services\Incrementer(false)
        );



        $this->assertEquals(
            0,
            $container->incrementer->getI()
        );

        $container->incrementer->increment();

        $this->assertEquals(
            0,
            $container->incrementer->getI()
        );
    }



    public function testShared()
    {
        $container = new Container();

        $container->add(
            new \Services\Incrementer(true)
        );



        $this->assertEquals(
            0,
            $container->incrementer->getI()
        );

        $container->incrementer->increment();

        $this->assertEquals(
            1,
            $container->incrementer->getI()
        );
    }



    public function testRawService()
    {
        $container = new Container();

        $container->add(
            new \Sid\Container\RawService(
                "example",
                true,
                function (\Sid\Container\Container $container) {
                    return "hello";
                }
            )
        );



        $this->assertTrue(
            $container->has("example")
        );

        $this->assertEquals(
            "hello",
            $container->example
        );
    }



    public function testTypeHintedResolver()
    {
        $container = new Container();

        $container->add(
            new \Services\TypeHintedResolver()
        );

        $container->add(
            new \Services\Parameter("Sid")
        );



        $this->assertEquals(
            "The 'parameter' service says: Hello Sid",
            $container->typeHintedResolver
        );
    }
}
