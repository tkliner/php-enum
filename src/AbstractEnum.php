<?php declare(strict_types = 1);

/**
 * This file is part of the Speedy Components (http://stagemedia.cz)
 * Copyright (c) 2018 Tomáš Kliner
 */

namespace Speedy\Enum;

/**
 * Class AbstractEnum
 *
 * @author      Tomáš Kliner <kliner.tomas@gmail.com>
 * @since       1.0.0
 */
abstract class AbstractEnum
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array
     */
    private static $storage = [];

    /**
     * AbstractEnum constructor.
     * @param $value
     * @throws \UnexpectedValueException
     * @throws \ReflectionException
     */
    public function __construct($value)
    {
        if (false === $this->isValid($value)) {
            throw new \UnexpectedValueException(sprintf('Value %s isn\'t part of a defined enum', $value));
        }

        $this->value = $value;
    }

    /**
     * Return current enum value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get storage array by key or get all arrays
     *
     * @param string $key
     * @return array|null
     */
    private static function getStorage(string $key = null): array
    {
        if ($key !== null && isset(self::$storage[$key])) {
            return self::$storage[$key];
        }

        return self::$storage;
    }

    /**
     * Add data to storage array by key
     *
     * @param string $key
     * @param array $data
     */
    private static function addStorage(string $key, array $data): void
    {
        self::$storage[$key] = $data;
    }

    /**
     * Convert all constants child class to array
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function toArray(): array
    {
        $class = static::class;

        if (!\array_key_exists($class, static::getStorage())) {
            $reflection = new \ReflectionClass($class);
            static::addStorage($class, $reflection->getConstants());
        }

        return static::getStorage($class);
    }

    /**
     * Check that the specified value is within the specified range
     *
     * @param $value
     * @return bool
     * @throws \ReflectionException
     */
    public static function isValid($value): bool
    {
        return \in_array($value, static::toArray(), true);
    }

    /**
     * Return current value as string
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }

    /**
     * Return key from current value
     *
     * @return false|int|string
     * @throws \ReflectionException
     */
    public function getKey()
    {
        return static::find($this->value);
    }

    /**
     * Return array of keys
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getKeys(): array
    {
        return array_keys(static::toArray());
    }

    /**
     * Find key from array by value
     *
     * @param $value
     * @return false|int|string
     * @throws \ReflectionException
     */
    public static function find($value)
    {
        return \array_search($value, static::toArray(), true);
    }

    /**
     * Return array constant all items from class in pairs format
     *
     * @return array
     * @throws \UnexpectedValueException
     * @throws \ReflectionException
     */
    public static function getValues(): array
    {
        $returnArray = [];

        foreach (static::toArray() ?? [] as $key => $value) {
            $returnArray[$key] = new static($value);
        }

        return $returnArray;
    }

    /**
     * Return state if key was found
     *
     * @param $key
     * @return bool
     * @throws \ReflectionException
     */
    public static function isKeyValid($key): bool
    {
        $constArray = static::toArray();

        return isset($constArray[$key]);
    }

    /**
     * Return value which is match by key
     *
     * @param $key
     * @return mixed|null
     * @throws \ReflectionException
     */
    public static function getValueByKey($key)
    {
        $constArray = static::toArray();

        return $constArray[$key] ?? null;
    }
}
