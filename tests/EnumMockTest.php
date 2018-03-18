<?php declare(strict_types = 1);

/**
 * This file is part of the Speedy Components (http://stagemedia.cz)
 * Copyright (c) 2018 Tomáš Kliner
 */

namespace Speedy\Tests\Enum;


use PHPUnit\Framework\TestCase;

/**
 * Class EnumMockTest
 * @package Speedy\Tests\Enum
 * @author      Tomáš Kliner <kliner.tomas@gmail.com>
 */
class EnumMockTest extends TestCase
{
    public function testCreateEnumValid()
    {
        $enum = new EnumMock(EnumMock::STRING_FIRST);
        $this->assertSame(EnumMock::STRING_FIRST, $enum->getValue());

        $enum = new EnumMock(EnumMock::STRING_SECOND);
        $this->assertSame(EnumMock::STRING_SECOND, $enum->getValue());

        $enum = new EnumMock(EnumMock::NUMBER_THIRD);
        $this->assertSame(EnumMock::NUMBER_THIRD, $enum->getValue());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testCreateEnumInvalid()
    {
        new EnumMock('BLA');
    }

    public function testEnumToString()
    {
        $enum = new EnumMock(EnumMock::STRING_FIRST);
        $this->assertSame(EnumMock::STRING_FIRST, $enum->__toString());

        $enum = new EnumMock(EnumMock::NUMBER_THIRD);
        $this->assertEquals(EnumMock::NUMBER_THIRD, $enum->__toString());
    }

    public function testToArrayMethod()
    {
        $exceptedArray = [
            'STRING_FIRST'  => EnumMock::STRING_FIRST,
            'STRING_SECOND' => EnumMock::STRING_SECOND,
            'NUMBER_THIRD'  => EnumMock::NUMBER_THIRD,
            'ZERO'          => EnumMock::ZERO,
            'NULL'          => EnumMock::NULL,
            'BLANK'         => EnumMock::BLANK,
            'FALSE'         => EnumMock::BLANK,
        ];

        $enum = new EnumMock(EnumMock::STRING_FIRST);
        $this->assertEquals($exceptedArray, $enum::toArray());
    }

    /**
     * @dataProvider keyDataSet
     *
     * @param $input
     * @param $class
     * @param $excepted
     * @throws \ReflectionException
     */
    public function testEnumKey($input, $class, $excepted)
    {
        /** @var EnumMock $class */
        $class = new $class($input);
        $this->assertSame($excepted, $class->getKey($input), 'Returned key isn\'t same as excepted array');

    }

    public function keyDataSet()
    {
        return [
            [EnumMock::STRING_FIRST, EnumMock::class, 'STRING_FIRST'],
            [EnumMock::STRING_SECOND, EnumMock::class, 'STRING_SECOND'],
            [EnumMock::NUMBER_THIRD, EnumMock::class, 'NUMBER_THIRD'],
            [EnumMock::FALSE, EnumMock::class, 'FALSE'],
        ];
    }

    public function testKeys()
    {
        $values = EnumMock::getKeys();

        $exceptedArray = [
            'STRING_FIRST',
            'STRING_SECOND',
            'NUMBER_THIRD',
            'ZERO',
            'NULL',
            'BLANK',
            'FALSE',
        ];

        $this->assertSame($exceptedArray, $values);
    }

    public function testValues()
    {
        $values = EnumMock::getValues();

        $exceptedArray = [
            'STRING_FIRST'  => new EnumMock(EnumMock::STRING_FIRST),
            'STRING_SECOND' => new EnumMock(EnumMock::STRING_SECOND),
            'NUMBER_THIRD'  => new EnumMock(EnumMock::NUMBER_THIRD),
            'ZERO'          => new EnumMock(EnumMock::ZERO),
            'NULL'          => new EnumMock(EnumMock::NULL),
            'BLANK'         => new EnumMock(EnumMock::BLANK),
            'FALSE'         => new EnumMock(EnumMock::BLANK),
        ];

        $this->assertEquals($exceptedArray, $values);
    }

    public function testValidKey()
    {
        $this->assertTrue(EnumMock::isKeyValid('STRING_FIRST'));
        $this->assertFalse(EnumMock::isKeyValid('TEST_STRING_FIRST'));
    }

    /**
     * @dataProvider searchDataSet
     */
    public function testSearch($input, $class, $excepted)
    {
        $this->assertSame($excepted, $class::find($input));
    }

    public function searchDataSet()
    {
        return [
            ['first', EnumMock::class, 'STRING_FIRST'],
            ['second', EnumMock::class, 'STRING_SECOND'],
            [99, EnumMock::class, 'NUMBER_THIRD'],
            [false, EnumMock::class, 'FALSE'],
            [0, EnumMock::class, 'ZERO'],
            [null, EnumMock::class, 'NULL'],
            ['', EnumMock::class, 'BLANK'],
        ];
    }

}