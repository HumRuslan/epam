<?php

use PHPUnit\Framework\TestCase;
use src\oop\Commands\ExpoCommand;

class ExpoCommandTest extends TestCase
{
    /**
     * @var ExpoCommand
     */
    private ExpoCommand $command;

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
    public function commandPositiveDataProvider(): array
    {
        return [
            [1, 1, 1],
            [2, -1, 0.5],
            [2, 2, 4],
            [-4, 2, 16],
            [5, 3, 125],
            [-5, 3, -125],
            ['5', 0, 1],
            [-8, 1/3, -2],
            [4, 1/2, 2],
            [0.027, 1/3, 0.3],
            [-0.008, -1/3, -5],
        ];
    }

    /**
     * @dataProvider commandPositiveDataProvider
     * @param $a
     * @param $b
     * @param $expected
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
    }

    /**
     * @return array
     */
    public function commandNegativeDataProvider(): array
    {
        return [
            [-4, 1/2],
            [-4, -1/2],
            [-4, 1/8],
        ];
    }

    /**
     * @dataProvider commandNegativeDataProvider
     * @param $a
     * @param $b
     */

    public function testCommandNegativeSQR($a, $b)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->command->execute($a, $b);
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