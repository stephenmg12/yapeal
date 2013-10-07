<?php
namespace Yapeal\Entity\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Eve ISK data type.
 */
class ISKType extends Type
{
    const ISK = 'ISK';
    const PRECISION = 17;
    const SCALE = 2;
    /**
     * @{inheritdoc}
     *
     * @param array                                     $fieldDeclaration
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return string
     */
    public function getSqlDeclaration(
        array $fieldDeclaration,
        AbstractPlatform $platform
    ) {
        $fieldDeclaration['precision'] = (!isset($fieldDeclaration['precision'])
            || empty($fieldDeclaration['precision'])) ? self::PRECISION :
            $fieldDeclaration['precision'];
        $fieldDeclaration['scale'] = (!isset($fieldDeclaration['scale'])
            || empty($fieldDeclaration['scale'])) ? self::SCALE :
            $fieldDeclaration['scale'];
        return $platform->getDecimalTypeDeclarationSQL($fieldDeclaration);
    }
    /**
     * @{inheritdoc}
     *
     * @param mixed                                     $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @throws \DomainException
     * @return string
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null == $value) {
            $mess = 'Value can not be NULL';
            throw new \DomainException($mess);
        }
        return (string)$value;
    }
    /**
     * @{inheritdoc}
     *
     * @param mixed                                     $value
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     *
     * @return mixed|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : $value;
    }
    /**
     * @{inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return self::ISK;
    }
}
