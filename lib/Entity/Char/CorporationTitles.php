<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * CorporationTitles
 *
 * @ORM\Table(name="char_CorporationTitles")
 * @ORM\Entity
 * @package Yapeal\Entity\Char
 */
class CorporationTitles extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $titleID;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $titleName;
}
