<?php

namespace Doctrine\DBAL\Types;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Type that maps an SQL DATE to a PHP Date object.
 */
class DateType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return Types::DATE_MUTABLE;
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getDateTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     *
     * @psalm-param T $value
     *
     * @return (T is null ? null : string)
     *
     * @template T
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format($platform->getDateFormatString());
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', 'DateTime']);
    }

    /**
     * {@inheritdoc}
     *
     * @param T $value
     *
     * @return (T is null ? null : DateTimeInterface)
     *
     * @template T
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof DateTimeInterface) {
            return $value;
        }

        $val = DateTime::createFromFormat('!' . $platform->getDateFormatString(), $value);
        if ($val === false) {
            throw ConversionException::conversionFailedFormat(
                $value,
                $this->getName(),
                $platform->getDateFormatString(),
            );
        }

        return $val;
    }
}
