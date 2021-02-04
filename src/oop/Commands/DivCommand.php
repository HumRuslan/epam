<?php

namespace src\oop\Commands;

class DivCommand implements CommandInterface
{
    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        if (2 != sizeof($args)) {
            throw new \InvalidArgumentException('Not enough parameters');
        } elseif ($args[1] == 0) {
            throw new \InvalidArgumentException('Division by zero');
        }

        return $args[0] / $args[1];
    }
}