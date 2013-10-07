<?php

namespace Yapeal\Entity\Fetcher;

use Doctrine\ORM\Mapping as ORM;

/**
 * CachedUntil
 *
 * @ORM\Table(name="fetcher_CachedUntil", indexes={@ORM\Index(name="until_idx", columns={"cachedUntil"})})
 * @ORM\Entity(repositoryClass="CachedUntilRepository")
 */
class CachedUntil {
  /**
   * @var integer
   * @ORM\Column(type="bigint")
   * @ORM\Id
   */
  private $ownerID;
  /**
   * @var string
   * @ORM\Column(type="string", length=32)
   * @ORM\Id
   */
  private $apiName;
  /**
   * @var \DateTime
   * @ORM\Column(type="datetime")
   */
  private $cachedUntil;
  /**
   * @var string
   * @ORM\Column(type="string", length=8)
   */
  private $sectionName;
}
