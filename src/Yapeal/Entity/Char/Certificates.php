<?php

namespace Yapeal\Entity\Char;

use Doctrine\ORM\Mapping as ORM;

/**
 * Certificates
 *
 * @ORM\Table(name="char_Certificates")
 * @ORM\Entity
 */
class Certificates extends AbstractCharacterOwner
{
    /**
     * @var integer
     * @ORM\Column(type="bigint")
     * @ORM\Id
     */
    private $certificateID;
}
