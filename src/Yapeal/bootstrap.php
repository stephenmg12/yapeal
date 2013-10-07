<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/3/13
 * Time: 7:33 AM
 * To change this template use File | Settings | File Templates.
 */
// bootstrap.php
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once "../../vendor/autoload.php";
// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$entities = array(__DIR__ . '/Entity/', __DIR__ . '/Entity/Account/');
$config = Setup::createAnnotationMetadataConfiguration(
    $entities,
    $isDevMode,
    null,
    null,
    false
);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);
// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'YapealUser',
    'password' => 'secret',
    'host' => 'localhost',
    'dbname' => 'yapeal-dev',
    'charset' => 'UTF-8'
);
// Register my types
Type::addType('ISK', 'Yapeal\Entity\Types\ISKType');
// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
$con = $entityManager->getConnection();
$con->getDatabasePlatform()->registerDoctrineTypeMapping('decimal', 'ISK');
