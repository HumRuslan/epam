<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, countArguments(...$input));
    }

    public function positiveDataProvider()
    {
        return [
            [[], [
                'argument_count'  => 0,
                'argument_values' => [],
            ]],
            [ ['string'], [
                'argument_count'  => 1,
                'argument_values' => ['string'],
            ]],
            [ ['string1', 'string2'], [
                'argument_count'  => 2,
                'argument_values' => ['string1', 'string2'],
            ]],
        ];
    }
}