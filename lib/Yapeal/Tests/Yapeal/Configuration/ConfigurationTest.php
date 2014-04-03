<?php
namespace Yapeal\Tests\Yapeal\Configuration;

use org\bovigo\vfs as VFS;
use PHPUnit_Framework_TestCase;
use Yapeal\Configuration\Configuration;

/**
 * Class ConfigurationTest
 *
 * @package Yapeal\Tests\Yapeal\Configuration
 */
class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $yapealTemplate = file_get_contents(
            dirname(dirname(dirname(__DIR__)))
            . '/config/yapeal-example.yaml'
        );
        $structure = array(
            'lib' => array(
                'Yapeal' => array(
                    'config' => array(
                        'yapeal.ini' => 'bogus',
                        'yapeal.json' => 'bogus',
                        'yapeal.yaml' => $yapealTemplate,
                        'yapeal-example.json' => 'bogus',
                        'yapeal-example.yaml' => $yapealTemplate
                    ),
                    'Configuration' => array(
                        'yapeal-schema.json' => 'bogus'
                    )
                )
            ),
            'config' => array(
                'yapeal.json' => 'bogus',
                'yapeal-example.json' => 'bogus'
            ),
            'my' => array(
                'web' => array(
                    'app' => array(
                        'vendor' => array(
                            'Yapeal' => array(
                                'Configuration' => array()
                            )
                        ),
                        'lib' => array(
                            'my-app' => array(
                                'Config' => array()
                            )
                        )
                    )
                )
            )
        );
        $this->vfs = VFS\vfsStream::setup('phpUnit', null, $structure);
        $this->configPath = $this->vfs->url() . '/lib/Yapeal/Configuration';
    }
    public function testAddConfigFilesWhenFilesParamIsArray()
    {
        $expectedResult = $this->vfs->url() . '/lib/Yapeal/config/yapeal.yaml';
        $config = new Configuration(null, null, $this->configPath);
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
        $input = '{libraryBase}/config/yapeal-example.json';
        $config->addConfigFiles((array)$input);
        $expectedResult = $this->vfs->url() . '/config/yapeal-example.json';
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
    }
    public function testAddConfigFilesWhenFilesParamIsString()
    {
        $input = '{libraryBase}/config/yapeal-example.json';
        $expectedResult =
            $this->vfs->url() . '/config/yapeal-example.json';
        $config = new Configuration(null, null, $this->configPath);
        $config->addConfigFiles($input);
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
    }
    public function testConstructorWhenFilesParamIsArray()
    {
        $input = '{libraryBase}/config/yapeal-example.json';
        $expectedResult =
            array($this->vfs->url() . '/config/yapeal-example.json');
        $config = new Configuration((array)$input, null, $this->configPath);
        $this->assertAttributeEquals($expectedResult, 'configFiles', $config);
    }
    public function testConstructorWhenFilesParamIsArrayWithInvalidTypeElement()
    {
        $logger = $this->getMockBuilder('Psr\Log\NullLogger')
                       ->disableOriginalConstructor()
                       ->getMock();
        $logger->expects($this->atLeastOnce())
               ->method('log');
        $input = array(1.0);
        $expectedResult = array(1.0);
        $config = new Configuration($input, $logger, $this->configPath);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testConstructorWhenFilesParamIsInvalidType()
    {
        $logger = $this->getMockBuilder('Psr\Log\NullLogger')
                       ->disableOriginalConstructor()
                       ->getMock();
        $logger->expects($this->atLeastOnce())
               ->method('log');
        $input = 1.0;
        $expectedResult = 1.0;
        $config = new Configuration($input, $logger, $this->configPath);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testConstructorWhenFilesParamIsString()
    {
        $input = '{libraryBase}/config/yapeal.json';
        $expectedResult = array($this->vfs->url() . '/config/yapeal.json');
        $config = new Configuration($input, null, $this->configPath);
        $this->assertAttributeEquals($expectedResult, 'configFiles', $config);
    }
    public function testSetConfigFilesDoesNotAllowAbsoluteDirectoryPathString()
    {
        $logger = $this->getMockBuilder('Psr\Log\NullLogger')
                       ->disableOriginalConstructor()
                       ->getMock();
        $logger->expects($this->atLeastOnce())
               ->method('log');
        $input = '/config/yapeal-example.json';
        $expectedResult = $input;
        $config = new Configuration(null, $logger, $this->configPath);
        $config->setConfigFiles($input);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testSetConfigFilesDoesNotAllowMultipleUriTemplatePathString(
    )
    {
        $logger = $this->getMockBuilder('Psr\Log\NullLogger')
                       ->disableOriginalConstructor()
                       ->getMock();
        $logger->expects($this->atLeastOnce())
               ->method('log');
        $input = '{vendorParent}/{libraryBase}/config/yapeal-example.json';
        $expectedResult = $input;
        $config = new Configuration(null, $logger, $this->configPath);
        $config->setConfigFiles($input);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testSetConfigFilesDoesNotAllowUnknownUriTemplatePathString()
    {
        $logger = $this->getMockBuilder('Psr\Log\NullLogger')
                       ->disableOriginalConstructor()
                       ->getMock();
        $logger->expects($this->atLeastOnce())
               ->method('log');
        $input = '{Bogus}/config/yapeal-example.json';
        $expectedResult = $input;
        $config = new Configuration(null, $logger, $this->configPath);
        $config->setConfigFiles($input);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testSetConfigFilesDoesNotAllowUpDirectoryPathString()
    {
        $logger = $this->getMockBuilder('Psr\Log\NullLogger')
                       ->disableOriginalConstructor()
                       ->getMock();
        $logger->expects($this->atLeastOnce())
               ->method('log');
        $input = '{libraryBase}/../config/yapeal-example.json';
        $expectedResult = $input;
        $config = new Configuration(null, $logger, $this->configPath);
        $config->setConfigFiles($input);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testSetConfigFilesWithPathStringAndFileDoesNotExist()
    {
        $input = '{libraryBase}/config/yapeal-example.ini';
        $expectedResult = $this->vfs->url() . '/lib/config/yapeal-example.ini';
        $config = new Configuration(null, null, $this->configPath);
        $config->setConfigFiles($input);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testSetConfigFilesWithPathStringAndFileExists()
    {
        $input = '{libraryBase}/config/yapeal-example.json';
        $expectedResult =
            array($this->vfs->url() . '/config/yapeal-example.json');
        $config = new Configuration(null, null, $this->configPath);
        $config->setConfigFiles($input);
        $this->assertAttributeEquals($expectedResult, 'configFiles', $config);
    }
    public function testSetLibraryBase()
    {
        $input = $this->vfs->url() . '/my/web/app/lib/my-app/Config';
        $expectedResult = $this->vfs->url() . '/my/web/app';
        $config = new Configuration();
        $config->setLibraryBase($input);
        $this->assertAttributeEquals($expectedResult, 'libraryBase', $config);
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
        $expectedResult = $this->vfs->url() . '/my/web/app/lib/my-app';
        $config->setLibraryBase($input, 'Config');
        $this->assertAttributeEquals($expectedResult, 'libraryBase', $config);
        $input =
            $this->vfs->url() . '/my/web/app/vendor/lib/lib/lib/Configuration';
        $expectedResult = $this->vfs->url() . '/my/web/app/vendor';
        $config->setLibraryBase($input);
        $this->assertAttributeEquals($expectedResult, 'libraryBase', $config);
        $expectedResult = $this->vfs->url() . '/my/web/app';
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
    }
    public function testSetVendorParent()
    {
        $input =
            $this->vfs->url() . '/my/web/app/vendor/Yapeal/Configuration';
        $config = new Configuration();
        $config->setVendorParent($input, 'lib');
        $expectedResult = $this->vfs->url() . '/my/web/app';
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
        $input =
            $this->vfs->url() . '/my/web/app/lib/my-app/Config';
        $config->setVendorParent($input);
        $expectedResult = $this->vfs->url() . '/my/web/app';
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
    }
    /**
     * @var string
     */
    private $configPath;
    /**
     * @var VFS\vfsStreamContent
     */
    private $vfs;
}
