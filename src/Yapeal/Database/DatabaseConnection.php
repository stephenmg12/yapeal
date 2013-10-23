<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/9/13
 * Time: 8:42 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Yapeal\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class DatabaseConnection implements DatabaseInterface
{
    private $em;
    public function __construct()
    {
        $conn = array(
            'driver' => 'pdo_mysql',
            'user' => 'YapealUser',
            'password' => 'secret',
            'host' => 'localhost',
            'dbname' => 'yapeal',
            'charset' => 'UTF-8'
        );
        $isDevMode = true;
        $entities = array(__DIR__ . '/Entity/');
        $config = Setup::createAnnotationMetadataConfiguration(
            $entities,
            $isDevMode,
            null,
            null,
            false
        );
        $this->em = EntityManager::create($conn, $config);
    }
}
