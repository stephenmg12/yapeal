<?php
/**
 * Contains Configuration class
 *
 * PHP version 5.3
 *
 * LICENSE: This file is part of Yet Another Php Eve Api library also know as Yapeal which will be used to refer to it
 * in the rest of this license.
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @author    Michael Cummings <mgcummings@yahoo.com>
 * @copyright 2013 Michael Cummings
 * @license   http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link      http://code.google.com/p/yapeal/
 * @link      http://www.eveonline.com/
 */
namespace Yapeal\Configuration;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\Log\NullLogger;
use Symfony\Component\Config\Definition\Builder as SCCDB;

/**
 * Class Configuration
 *
 * @package Yapeal\Configuration
 */
class Configuration implements ConfigurationInterface, LoggerAwareInterface
{
    /**
     * @param string|string[]|null $files Configuration files to look for if
     *                                    null use defaults.
     * @param LoggerInterface      $logger
     * @param string|null          $libraryBase
     * @param SCCDB\TreeBuilder    $treeBuilder
     *
     * @return Configuration
     */
    public function __construct(
        $files = null,
        LoggerInterface $logger = null,
        $libraryBase = null,
        SCCDB\TreeBuilder $treeBuilder = null
    ) {
        $this->setLogger($logger);
        $this->setLibraryBase($libraryBase);
        $this->setConfigFiles($files);
        $this->setTreeBuilder($treeBuilder);
    }
    /**
     * Add one or more names of configuration files to be looked for and used.
     *
     * @param string|string[] $files
     *
     * @return self
     * @uses Configuration::getCleanPath() Configuration::getCleanPath()
     */
    public function addConfigFiles($files)
    {
        if (is_string($files)) {
            $files = (array)$files;
        } elseif (!is_array($files)) {
            $mess = '$files MUST be a string or an array but received '
                . gettype($files);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        foreach ($files as $file) {
            if (!is_string($file)) {
                $mess =
                    '$files MUST contain strings only but received ';
                $mess .= gettype($file);
                $this->logger->log(LogLevel::WARNING, $mess);
                continue;
            }
            // Returns false if problem with path.
            $path = $this->getCleanPath(dirname($file));
            if (false === $path) {
                continue;
            }
            $file = $path . '/' . basename($file);
            if (file_exists($file) && is_file($file) && is_readable($file)) {
                $this->configFiles[] = $file;
            }
        }
        // Ensure config files only included once.
        $this->configFiles = array_merge(array_unique($this->configFiles));
        return $this;
    }
    /**
     * @return string[]
     */
    public function getConfigFiles()
    {
        return $this->configFiles;
    }
    /**
     * @return SCCDB\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $applicationAgent =
            '{application_agent} Yapeal/{version} {stability} ({OS} {arch}) libcurl/{curl_version}';
        $rootNode = $this->treeBuilder->root('');
        $rootNode
            ->children()
            ->arrayNode('yapeal')
            ->children()
            ->scalarNode('application_agent')
            ->defaultValue($applicationAgent)
            ->end()
            ->enumNode('registered_mode')
            ->values(array('ignored', 'optional', 'required'))
            ->defaultValue('optional')
            ->end()
            ->append($this->cacheNode())
            ->append($this->databaseNode())
            ->append($this->loggingNode())
            ->end()
            ->end()
            ->end();
        return $this->treeBuilder;
    }
    /**
     * Set the name or names of configuration files to be looked for and used.
     *
     * @param string|string[]|null $files Configuration files to look for if
     *                                    null use defaults.
     *
     * @return self
     * @throws \InvalidArgumentException Throw exception if $files is incorrect
     * type.
     */
    public function setConfigFiles($files = null)
    {
        $this->configFiles = array();
        if (is_null($files)) {
            $files = array(
                $this->libraryBase . '/lib/Yapeal/config/yapeal.ini',
                $this->libraryBase . '/lib/Yapeal/config/yapeal.json',
                $this->libraryBase . '/lib/Yapeal/config/yapeal.yaml',
                $this->vendorParent . '/config/yapeal.ini',
                $this->vendorParent . '/config/yapeal.json',
                $this->vendorParent . '/config/yapeal.yaml'
            );
        }
        return $this->addConfigFiles($files);
    }
    /**
     * Finds the base of library path.
     *
     * The method assumes that any path that does not contain "/$base" is the
     * base being looked for. In other words if given $path that does not
     * contain '/lib' by default then it will use the value of $path.
     *
     * Some examples:
     * <pre>
     * $path = '/my/project/base/lib';
     * Configuration::setLibraryBase($path);
     * // $this->libraryBase = '/my/project/base'
     *
     * $path = 'my/web/site';
     * Configuration::setLibraryBase($path);
     * // $this->libraryBase = 'my/web/site'
     *
     * $path = '/my/project/base/deeper';
     * $base = 'deeper';
     * Configuration::setLibraryBase($path, $base);
     * // $this->libraryBase = '/my/project/base'
     *
     * $path = '/my/system/lib/some/other/library';
     * Configuration::setLibraryBase($path);
     * // $this->libraryBase = '/my/system'
     *
     * $path = 'C:\\my\project\lib';
     * Configuration::setLibraryBase($path);
     * // $this->libraryBase = 'C://my/project'
     * // Note all of the '\' changed to '/'.
     * </pre>
     *
     * The following examples would cause problems:
     * <pre>
     * $path = '/my/project/lib';
     * $base = '/lib';
     * Configuration::setLibraryBase($path, $base);
     * // The '/' is automatically prefixed to $base so becomes
     * // $base = '//lib' and
     * // $this->libraryBase = '/my/project/lib'
     * </pre>
     *
     * @param string $path
     * @param string $base
     *
     * @return self
     * @uses Configuration::setVendorParent()
     */
    public function setLibraryBase($path = __DIR__, $base = 'lib')
    {
        if (!is_string($base)) {
            $mess = '$base MUST be a string but received '
                . gettype($base);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        if (!is_string($path)) {
            $mess = '$path MUST be a string but received '
                . gettype($path);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $base = '/' . $base;
        $path = str_replace('\\', '/', $path);
        // Search up through $path until $base is no longer found.
        while (false !== strpos($path, $base)) {
            $path = dirname($path);
        }
        if (!file_exists($path) || !is_dir($path) || !is_readable($path)) {
            $mess = '$path is NOT accessible please check permissions on '
                . $path;
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $this->libraryBase = $path;
        $this->setVendorParent($path);
        return $this;
    }
    /**
     * @param LoggerInterface $logger
     *
     * @return null|void
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger ? : new NullLogger();
    }
    /**
     * @param SCCDB\TreeBuilder $value
     *
     * @return self
     */
    public function setTreeBuilder(SCCDB\TreeBuilder $value = null)
    {
        $this->treeBuilder = $value ? : new SCCDB\TreeBuilder();
        return $this;
    }
    /**
     * Finds parent directory of vendor path.
     *
     * Normally this should never need to be called directly if you use composer
     * standard directory layout as {@link Configuration::setLibraryBase()}
     * calls this method with a path that would allow the vendor parent path to
     * be found.
     *
     * If the method is give an accessible path with $vendor in it the method
     * will directly find the parent from $path. If not the method checks to see
     * if the $path is already an accessible parent or if not the method checks
     * to see if the $path of some part of it is a sibling to $vendor that the
     * method can use to find the parent.
     *
     * If none of the above find $vendor's parent it will be left as is.
     *
     * WARNING: MUST use only Unix style paths as will NOT work with Windows
     * style paths that use '\'.
     *
     * Some examples:
     * <pre>
     * $path = '/my/project/base/vendor';
     * Configuration::setVendorParent($path);
     * // $this->vendorParent = '/my/project/base'
     *
     * $path = 'my/web/site';
     * // and "my/web/site/$vendor" exists and is an accessible path.
     * Configuration::setVendorParent($path);
     * // $this->vendorParent = 'my/web/site'
     *
     * $path = '/my/project/base/externals';
     * $vendor = 'externals';
     * Configuration::setVendorParent($path, $vendor);
     * // $this->vendorParent = '/my/project/base'
     *
     * $path = '/my/system/vendor/some/other/library';
     * Configuration::setVendorParent($path);
     * // $this->vendorParent = '/my/system'
     * </pre>
     *
     * The following examples would cause problems:
     * <pre>
     * $path = 'C:\\my\project\vendor';
     * Configuration::setVendorParent($path);
     * // Windows style path using '\' will NOT match
     * // $vendor = '/vendor' after automatic prefixing of the '/'.
     *
     * $path = '/my/project/vendor';
     * $vendor = '/vendor';
     * Configuration::setVendorParent($path, $vendor);
     * // The '/' is automatically prefixed to $vendor so becomes
     * // $vendor = '//vendor' and will NOT match.
     * </pre>
     *
     * @param string $path
     * @param string $vendor
     *
     * @return self
     */
    public function setVendorParent($path, $vendor = 'vendor')
    {
        if (!is_string($vendor)) {
            $mess = '$vendor MUST be a string but received '
                . gettype($vendor);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        if (!is_string($path)) {
            $mess = '$path MUST be a string but received '
                . gettype($path);
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $vendor = '/' . $vendor;
        // Search up through $path until $vendor is no longer found.
        while (false !== strpos($path, $vendor)) {
            $path = dirname($path);
        }
        while (!(file_exists($path . $vendor) && is_dir($path . $vendor)
            && is_readable($path . $vendor))) {
            if ($path == dirname($path)) {
                $mess = 'Could not find accessible $vendor\'s parent';
                $this->logger->log(LogLevel::WARNING, $mess);
                return $this;
            }
            $path = dirname($path);
        }
        if (!file_exists($path) || !is_dir($path) || !is_readable($path)) {
            $mess = '$path is NOT accessible please check permissions on '
                . $path;
            $this->logger->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $this->vendorParent = $path;
        return $this;
    }
    /**
     * Fetches, parses, and merges all existing configuration files into a
     * single unified configuration.
     *
     * @param ConfigFactoryInterface $factory
     * @param LoggerInterface        $logger
     *
     * @return self
     */
    public function unifyConfiguration(
        ConfigFactoryInterface $factory = null,
        LoggerInterface $logger = null
    ) {
        if (is_null($logger)) {
            $logger = $this->logger;
        }
        if (is_null($factory)) {
            $factory = new ConfigurationFactory($logger);
        }
        $unified = array();
        foreach ($this->configFiles as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $handler = $factory->getHandler($extension);
            $data = $handler->processConfiguration($file)
                            ->getProcessedConfigurationAsStringArray();
            $unified = array_replace_recursive($unified, $data);
        }
        $this->unified = $unified;
    }
    /**
     * Get a cleaned up full path.
     *
     * The method converts all Windows style path with '\' into Unix style with
     * '/' instead as PHP can always use them no matter the platform being used.
     *
     * The method understands URI style templates but only for '{libraryBase}'
     * or '{vendorParent}' when used at the beginning of the path.
     *
     * Some examples:
     * <pre>
     * $path = '{libraryBase}/config';
     * $path = '{vendorParent}\config';
     * </pre>
     *
     * The following examples would NOT be allowed:
     * <pre>
     * // {vendorParent} | {libraryBase} NOT both at same time.
     * $path = '{vendorParent}/{libraryBase}/config/dir';
     * // Can NOT use URI template anywhere but at start.
     * $path = 'dir/{libraryBase}/more/dir';
     * // Up directory paths NOT allowed.
     * $path = '../../no-way';
     * // Absolute paths NOT allowed either.
     * $path = '/lib/not-happening';
     * // Unknown URI templates NOT allowed.
     * $path = '{myTemplate}/no-no'
     * </pre>
     *
     * @param string $path
     *
     * @return string|bool
     * @link http://tools.ietf.org/html/rfc6570 URI Templates
     */
    protected function getCleanPath($path)
    {
        $ds = '/';
        $path = str_replace('\\', $ds, $path);
        if (substr($path, 0, 1) == $ds) {
            $mess = '$path can NOT be absolute';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        if (strpos($path, "..$ds") !== false) {
            $mess = '$path can NOT contain up directory reference';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        $search = array("{libraryBase}$ds", "{vendorParent}$ds");
        $replace = array($this->libraryBase . $ds, $this->vendorParent . $ds);
        $path = str_replace($search, $replace, $path, $count);
        if ($count > 1) {
            $mess = '$path can NOT contain more than one URI template';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        if (strpos($path, '{') !== false && strpos($path, '}') !== false) {
            $mess = '$path can NOT contain unknown URI templates';
            $this->logger->log(LogLevel::WARNING, $mess);
            return false;
        }
        return $path;
    }
    /**
     * @var string[] Holds a list of existing absolute path config files.
     */
    private $configFiles;
    /**
     * @var string
     */
    private $libraryBase;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SCCDB\TreeBuilder
     */
    private $treeBuilder;
    /**
     * @var string[]
     */
    private $unified;
    /**
     * @var string
     */
    private $vendorParent;
    /**
     * @param SCCDB\TreeBuilder $builder
     *
     * @return SCCDB\ArrayNodeDefinition|SCCDB\NodeDefinition
     */
    private function cacheNode(SCCDB\TreeBuilder $builder = null)
    {
        $builder = $builder ? : new SCCDB\TreeBuilder();
        $node = $builder->root('Cache');
        $node
            ->isRequired()
            ->children()
            ->scalarNode('dir')
            ->defaultValue('{libraryBase}/cache')
            ->end()
            ->integerNode('interval')
            ->min(0)
            ->max(366)
            ->defaultValue(7)
            ->end()
            ->enumNode('to')
            ->defaultValue('file')
            ->values(array('none', 'file', 'database', 'both'))
            ->end()
            ->end();
        return $node;
    }
    /**
     * @param SCCDB\TreeBuilder $builder
     *
     * @return SCCDB\ArrayNodeDefinition|SCCDB\NodeDefinition
     */
    private function databaseNode(SCCDB\TreeBuilder $builder = null)
    {
        $builder = $builder ? : new SCCDB\TreeBuilder();
        $node = $builder->root('Database');
        $node
            ->isRequired()
            ->children()
            ->scalarNode('dbname')
            ->defaultValue('yapeal')
            ->end()
            ->scalarNode('host')
            ->defaultValue('localhost')
            ->end()
            ->scalarNode('password')
            ->defaultValue('secret')
            ->end()
            ->enumNode('prefix')
            ->defaultValue('mysql')
            ->values(array('mysql', 'pgsql', 'sqlite'))
            ->end()
            ->scalarNode('user')
            ->defaultValue('yapealUser')
            ->end()
            ->end();
        return $node;
    }
    /**
     * @param SCCDB\TreeBuilder $builder
     *
     * @return SCCDB\ArrayNodeDefinition|SCCDB\NodeDefinition
     */
    private function loggingNode(SCCDB\TreeBuilder $builder = null)
    {
        $level = array(
            'emergency',
            'alert',
            'critical',
            'error',
            'warning',
            'notice',
            'info',
            'debug'
        );
        $builder = $builder ? : new SCCDB\TreeBuilder();
        $node = $builder->root('Logging');
        $node
            ->isRequired()
            ->children()
            ->scalarNode('dir')
            ->defaultValue('{libraryBase}/log')
            ->end()
            ->enumNode('level')
            ->defaultValue('warning')
            ->values($level)
            ->end()
            ->scalarNode('locale')
            ->defaultValue('en_US')
            ->end()
            ->end();
        return $node;
    }
}
