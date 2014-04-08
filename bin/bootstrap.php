<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/3/13
 * Time: 7:33 AM
 * To change this template use File | Settings | File Templates.
 */
// bootstrap.php
use Doctrine\DBAL\Migrations\Tools\Console\Command;
use Doctrine\DBAL\Tools\Console\Helper;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Version;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper as SHelper;

(@include_once dirname(__DIR__) . '/autoload.php')
|| (@include_once __DIR__ . '/vendor/autoload.php')
|| (@include_once dirname(__DIR__) . '/vendor/autoload.php')
|| (@include_once dirname(dirname(__DIR__)) . '/vendor/autoload.php')
|| (@include_once dirname(dirname(dirname(__DIR__))) . '/autoload.php')
|| die('Could not find required auto class loader. Aborting ...');
// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$entities = array(__DIR__ . '/Entity/');
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
    'dbname' => 'yapeal',
    'charset' => 'utf8'
);
// Register my types
Type::addType('ISK', 'Yapeal\Entity\Types\ISKType');
// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
$con = $entityManager->getConnection();
$con->getDatabasePlatform()
    ->registerDoctrineTypeMapping('decimal', 'ISK');
$helperSet = new SHelper\HelperSet(
    array(
        'db' => new Helper\ConnectionHelper($con),
        'dialog' => new SHelper\DialogHelper(),
        'em' => new EntityManagerHelper(
            $entityManager
        )
    )
);
$cli =
    new Application(
        'Doctrine Command Line Interface',
        Version::VERSION
    );
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);
$cli->addCommands(
    array(
        // Migrations Commands
        new Command\DiffCommand(),
        new Command\ExecuteCommand(),
        new Command\GenerateCommand(),
        new Command\MigrateCommand(),
        new Command\StatusCommand(),
        new Command\VersionCommand()
    )
);
// Register All Doctrine Commands
ConsoleRunner::addCommands($cli);
// Runs console application
$cli->run();