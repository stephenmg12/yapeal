<?php
namespace Yapeal\Tests\Yapeal\Configuration;

use org\bovigo\vfs as VFS;
use PHPUnit_Framework_TestCase;
use Yapeal\Configuration\Configuration;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $libraryPath;
    /**
     * @var VFS\vfsStreamContent
     */
    private $vfs;
    public function setUp()
    {
        $yapealTemplate = file_get_contents(
            __DIR__ . '../../../../Configuration/yapeal-template.json'
        );
        $structure = array(
            'src' => array(
                'config' => array(
                    'yapeal.ini' => 'bogus',
                    'yapeal.json' => 'bogus',
                    'yapeal-example.json' => 'bogus'
                ),
                'Configuration' => array(
                    'yapeal-template.json' => $yapealTemplate,
                    'yapeal-schema.json' => 'bogus'
                )
            ),
            'config' => array(
                'yapeal.json' => 'bogus'
            )
        );
        $this->vfs = VFS\vfsStream::setup('phpUnit', null, $structure);
        $this->libraryPath = $this->vfs->url() . '/src/Configuration';
    }
    public function testAddConfigFilesWhenFilesParamIsArray()
    {
        $input = '{libraryBase}/config/yapeal-example.json';
        $expectedResult = $this->vfs->url() . '/src/config/yapeal.ini';
        $config = new Configuration(null, null, $this->libraryPath);
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
        $config->addConfigFiles((array)$input);
        $expectedResult = $this->vfs->url() . '/src/config/yapeal-example.json';
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
    }
    public function testAddConfigFilesWhenFilesParamIsString()
    {
        $input = '{libraryBase}/config/yapeal-example.json';
        $expectedResult = $this->vfs->url() . '/src/config/yapeal-example.json';
        $config = new Configuration(null, null, $this->libraryPath);
        $config->addConfigFiles($input);
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
    }
    public function testConstructorWhenFilesParamIsArray()
    {
        $input = '{libraryBase}/config/yapeal-example.json';
        $expectedResult =
            array($this->vfs->url() . '/src/config/yapeal-example.json');
        $config = new Configuration((array)$input, null, $this->libraryPath);
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
        $config = new Configuration($input, $logger, $this->libraryPath);
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
        $config = new Configuration($input, $logger, $this->libraryPath);
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testConstructorWhenFilesParamIsString()
    {
        $input = '{libraryBase}/config/yapeal.ini';
        $expectedResult = array($this->vfs->url() . '/src/config/yapeal.ini');
        $config = new Configuration($input, null, $this->libraryPath);
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
        $config = new Configuration(null, $logger, $this->libraryPath);
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
        $config = new Configuration(null, $logger, $this->libraryPath);
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
        $config = new Configuration(null, $logger, $this->libraryPath);
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
        $config = new Configuration(null, $logger, $this->libraryPath);
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
        $expectedResult = $this->vfs->url() . '/src/config/yapeal-example.ini';
        $config = new Configuration(null, null, $this->libraryPath);
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
        $expectedResult = $this->vfs->url() . '/src/config/yapeal-example.json';
        $config = new Configuration(null, null, $this->libraryPath);
        $config->setConfigFiles($input);
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
    }
    public function testSetLibraryBase()
    {
        $input = '/my/web/app/src/Configuration';
        $expectedResult = '/my/web/app/src';
        $config = new Configuration();
        $config->setLibraryBase($input);
        $this->assertAttributeEquals($expectedResult, 'libraryBase', $config);
        $expectedResult = '/my/web/app';
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
        $expectedResult = $input;
        $config->setLibraryBase($input, 'Configuration');
        $this->assertAttributeEquals($expectedResult, 'libraryBase', $config);
        $input = '/my/web/app/vendor/src/src/src/Configuration';
        $expectedResult = '/my/web/app/vendor/src';
        $config->setLibraryBase($input);
        $this->assertAttributeEquals($expectedResult, 'libraryBase', $config);
        $expectedResult = '/my/web/app';
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
    }
    public function testSetVendorParent()
    {
        $input = '/my/web/app/src/Configuration';
        $config = new Configuration();
        $config->setVendorParent($input, 'src');
        $expectedResult = '/my/web/app';
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
        $input = '/my/web/app/vendor/src/src/src/Configuration';
        $config->setVendorParent($input);
        $expectedResult = '/my/web/app';
        $this->assertAttributeEquals($expectedResult, 'vendorParent', $config);
    }
}
