<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/3/13
 * Time: 7:36 AM
 * To change this template use File | Settings | File Templates.
 */
// cli-config.php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once "bootstrap.php";
return ConsoleRunner::createHelperSet(
    $entityManager
);
