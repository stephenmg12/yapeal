<?php

namespace Yapeal\Entity\Fetcher;

use Doctrine\ORM\Mapping as ORM;

/**
 * CachedInterval
 *
 * @ORM\Table(name="fetcher_CacheInterval")
 * @ORM\Entity
 */
class CacheInterval {
  /**
   * @var string
   * @ORM\Column(type="string", length=8)
   * @ORM\Id
   */
  private $section;
  /**
   * @var string
   * @ORM\Column(type="string", length=32)
   * @ORM\Id
   */
  private $api;
  /**
   * @var integer
   * @ORM\Column(type="integer")
   */
  private $interval;
}
