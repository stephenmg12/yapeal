<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributeEnhancers
 *
 * @ORM\Table(name="char_AttributeEnhancers")
 * @ORM\Entity
 * @package src\Entity\Char
 */
class AttributeEnhancers extends AbstractCharacterOwner
{
    /**
     * @var string
     * @ORM\Column(type="string", length=24)
     * @ORM\Id
     */
    private $bonusName;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $augmentatorName;
    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    private $augmentatorValue;
}
