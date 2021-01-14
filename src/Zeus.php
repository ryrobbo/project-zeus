<?php

namespace Zeus;

use Psr\Container\ContainerInterface;

class Zeus
{
    private ContainerInterface $diContainer;

    public function __construct(ContainerInterface $container)
    {
        $this->diContainer = $container;
    }

    public function container(): ContainerInterface
    {
        return $this->diContainer;
    }
}
