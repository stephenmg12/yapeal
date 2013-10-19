<?php
namespace Yapeal\Tests\Yapeal\Configuration;

use PHPUnit_Framework_TestCase;
use Yapeal\Configuration\Configuration;
use Yapeal\Filesystem\Finder;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function testAddConfigFilesWhenFilesIsArray()
    {
        $expectedResult = 'test.xml';
        $config = new Configuration();
        $config->addConfigFiles((array)$expectedResult);
        $this->assertAttributeContains($expectedResult, 'searchFiles', $config);
    }
    public function testAddConfigFilesWhenFilesIsString()
    {
        $expectedResult = 'test.xml';
        $config = new Configuration();
        $config->addConfigFiles($expectedResult);
        $this->assertAttributeContains($expectedResult, 'searchFiles', $config);
    }
    public function testAddSearchPathsWhenPathsIsArray()
    {
        $expectedResult = 'test';
        $config = new Configuration();
        $config->addSearchPaths((array)$expectedResult);
        $this->assertAttributeContains($expectedResult, 'searchPaths', $config);
    }
    public function testAddSearchPathsWhenPathsIsString()
    {
        $expectedResult = 'test';
        $config = new Configuration();
        $config->addSearchPaths($expectedResult);
        $this->assertAttributeContains($expectedResult, 'searchPaths', $config);
    }
    public function testConstructorFilesParamIsArray()
    {
        $expectedResult = array('yapeal.ini', 'yapeal.json');
        $config = new Configuration(null, $expectedResult);
        $this->assertAttributeEquals($expectedResult, 'searchFiles', $config);
    }
    public function testConstructorFilesParamIsInvalidType()
    {
        //$this->setExpectedException('InvalidArgumentException');
        $expectedResult = 1.0;
        $config = new Configuration(null, $expectedResult);
        $this->assertAttributeNotContains(
            $expectedResult,
            'searchFiles',
            $config
        );
    }
    public function testConstructorFilesParamIsString()
    {
        $expectedResult = array('yapeal.ini');
        $config = new Configuration(null, 'yapeal.ini');
        $this->assertAttributeEquals($expectedResult, 'searchFiles', $config);
    }
    public function testConstructorParamsAreNull()
    {
        $expectedFilesResult = array('yapeal.ini', 'yapeal.json');
        $base = dirname(dirname(dirname(__DIR__)));
        $expectedSearchPathsResult = $base . '/config';
        $config = new Configuration();
        $this->assertAttributeEquals(
            $expectedFilesResult,
            'searchFiles',
            $config
        );
        $this->assertAttributeContains(
            $expectedSearchPathsResult,
            'searchPaths',
            $config
        );
    }
    public function testConstructorPathsParamIsArray()
    {
        $input = array('{libraryBase}/config', '{libraryBase}/etc');
        $expectedResult = array(
            Finder::getLibraryBasePath() . '/config',
            Finder::getLibraryBasePath() . '/etc'
        );
        $config = new Configuration($input, null);
        $this->assertAttributeEquals($expectedResult, 'searchPaths', $config);
    }
    public function testConstructorPathsParamIsInvalidType()
    {
        //$this->setExpectedException('InvalidArgumentException');
        $expectedResult = 1.0;
        $config = new Configuration($expectedResult, null);
        $this->assertAttributeNotContains(
            $expectedResult,
            'searchPaths',
            $config
        );
    }
    public function testConstructorPathsParamIsString()
    {
        $expectedResult = array('yapeal.ini');
        $config = new Configuration('yapeal.ini', null);
        $this->assertAttributeEquals($expectedResult, 'searchPaths', $config);
    }
    public function testSetConfigFilesWithRelativePathStringAndFileDoesNotExist(
    )
    {
        $expectedResult = 'config/yapeal.ini';
        $config = new Configuration(null, null);
        $config->setConfigFiles($expectedResult);
        $expectedResult = Finder::getLibraryBasePath() . '/' . $expectedResult;
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testSetConfigFilesWithRelativePathStringAndFileExists()
    {
        $input = '{libraryBase}/config/yapeal-example.ini';
        $expectedResult =
            Finder::getLibraryBasePath() . '/config/yapeal-example.ini';
        $config = new Configuration(null, null);
        $config->setConfigFiles($input);
        $this->assertAttributeContains($expectedResult, 'configFiles', $config);
    }
    public function testSetConfigFilesWithUpDirectoryPathString()
    {
        $expectedResult = 'config/../yapeal.ini';
        $config = new Configuration(null, null);
        $config->setConfigFiles($expectedResult);
        $expectedResult = Finder::getLibraryBasePath() . '/' . $expectedResult;
        $this->assertAttributeNotContains(
            $expectedResult,
            'configFiles',
            $config
        );
    }
    public function testSetPathsWithAbsolutePathsParam()
    {
        $expectedResult = '/Yapeal';
        $config = new Configuration(null, null);
        $config->setSearchPaths($expectedResult);
        $this->assertAttributeNotContains(
            $expectedResult,
            'searchPaths',
            $config
        );
    }
    public function testSetPathsWithMultipleURITemplatePathsParam()
    {
        $expectedResult = '{vendorParent}/{libraryBase}/Yapeal';
        $config = new Configuration(null, null);
        $config->setSearchPaths($expectedResult);
        $this->assertAttributeNotContains(
            $expectedResult,
            'searchPaths',
            $config
        );
    }
}
