<?php

use PHPUnit\Framework\TestCase;
use src\oop\Commands\ExpoCommand;

class ExpoCommandTest extends TestCase
{
    /**
     * @var ExpoCommand
     */
    private $command;

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function setUp(): void
    {
        $this->command = new ExpoCommand();
    }

    /**
     * @return array
     */
    public function commandPositiveDataProvider()
    {
        return [
            [1, 1, 1],
            [2, 2, 4],
            [5, 3, 125],
            [2, -1, 0.5],
            ['5', 0, 1],
            [-8, 1/3, -2],
            [4, 1/2, 2],
            [-4, 2, 16],
            [-5, 3, -125],
        ];
    }

    /**
     * @dataProvider commandPositiveDataProvider
     */
    public function testCommandPositive($a, $b, $expected)
    {
        $result = $this->command->execute($a, $b);

        $this->assertEquals($expected, $result);
    }

    public function testCommandNegative()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->command->execute(1);
        $this->command->execute(-4, 1/2);
    }

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function tearDown(): void
    {
        unset($this->command);
    }
}