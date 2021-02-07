<?php

namespace src\oop\Commands;

class ExpoCommand implements CommandInterface
{
    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        $sign = 1;

        if (2 != sizeof($args)) {
            throw new \InvalidArgumentException('Not enough parameters');
        }

        if ((abs($args[1]) < 1 && abs($args[1]) > 0) && (1 / abs($args[1]) % 2 == 0) && $args[0] < 0) {
            throw new \InvalidArgumentException('Invalid argument');
        } elseif (($args[0] < 0 && $args[1] % 2 != 0)
            || ($args[0] < 0 && (abs($args[1]) < 1 && abs($args[1]) > 0) && (1 / $args[1] % 2 != 0))) {
            $sign = -1;
        }

        return $sign * (abs($args[0]) ** $args[1]);
    }
}