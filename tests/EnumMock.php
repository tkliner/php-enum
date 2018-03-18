<?php declare(strict_types = 1);

/**
 * This file is part of the Speedy Components (http://stagemedia.cz)
 * Copyright (c) 2018 Tomáš Kliner
 */

namespace Speedy\Tests\Enum;

use Speedy\Enum\AbstractEnum;

/**
 * Class EnumMock
 *
 * @author      Tomáš Kliner <kliner.tomas@gmail.com>
 */
class EnumMock extends AbstractEnum
{
    public const STRING_FIRST = 'first';
    public const STRING_SECOND = 'second';
    public const NUMBER_THIRD = 99;

    public const ZERO = 0;
    public const NULL = null;
    public const BLANK = '';
    public const FALSE = false;
}