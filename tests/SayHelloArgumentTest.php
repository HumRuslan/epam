<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, sayHelloArgument($input));
    }

    public function positiveDataProvider()
    {
        return [
            [1, 'Hello 1'],
            ['string', 'Hello string'],
            [true, 'Hello 1'],
            [false, 'Hello '],
        ];
    }
}