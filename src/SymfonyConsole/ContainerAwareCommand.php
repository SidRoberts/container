<?php
 
namespace Sid\Container\SymfonyConsole;

use LogicException;
use Sid\Container\Container;
use Symfony\Component\Console\Command\Command;

class ContainerAwareCommand extends Command
{
    /**
     * @var Container|null
     */
    private $container;



    /**
     * @throws LogicException
     */
    protected function getContainer() : Container
    {
        if ($this->container === null) {
            throw new LogicException(
                "The container cannot be retrieved as it has not been set."
            );
        }

        return $this->container;
    }

    public function setContainer(Container $container = null)
    {
        $this->container = $container;
    }
}
