<?php

/**
 * UuidType
 * identifiant unique
 * php version 7.2.5
 *
 * @category   Doctrine
 * @package    Producteurauconsommateur
 * @subpackage App\Doctrine
 * @author     Bernard Thomas <ynofmys@gmail.com>
 * @copyright  2020 Bernard Thomas
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @version    GIT: feature/registration
 * @link       http://producteurauconsommateur.com/
 */

namespace App\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;
use InvalidArgumentException;

/**
 * Class UuidType
 * Uuid pour id
 *
 * @category Doctrine
 * @package  App\Doctrine
 * @author   Bernard Thomas <ynofmys@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://producteurauconsommateur.com/
 */
class UuidType extends GuidType
{
    /**
     * Nom du Type
     *
     * @var string nom du type
     */
    public const NAME = "uuid";

    /**
     * Getter name
     *
     * @return string name
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * Mappe de sql vers Php
     *
     * @param mixed            $value    valeur
     * @param AbstractPlatform $platform DataBasePlatform
     *
     * @return mixed| AbstractUid|Uuid|null
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }
        if ($value instanceof Uuid) {
            return $value;
        }
        try {
            $uuid = Uuid::fromString($value);
        } catch (InvalidArgumentException $e) {
            throw new ConversionException($value, static::NAME);
        }

        return $uuid;
    }

    /**
     * Mappe de php vers sql
     *
     * @param mixed            $value    valeur
     * @param AbstractPlatform $platform DataBasePlatform
     *
     * @return string|null
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (
            $value instanceof Uuid
            || ((is_string($value) || method_exists($value, '__toString')) && Uuid::isValid($value))
        ) {
            return (string) $value;
        }
        throw ConversionException::conversionFailed($value, static::NAME);
    }
}
