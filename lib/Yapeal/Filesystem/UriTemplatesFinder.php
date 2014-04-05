<?php
/**
 * Contains UriTemplatesFinder class.
 *
 * PHP version 5.3
 *
 * LICENSE:
 * This file is part of Yet Another Php Eve Api Library also know as Yapeal which can be used to access the Eve Online
 * API data and place it into a database.
 * Copyright (C) 2014 Michael Cummings
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General
 * Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * You should be able to find a copy of this license in the LICENSE.md file. A copy of the GNU GPL should also be
 * available in the GNU-GPL.md file.
 *
 * @copyright 2014 Michael Cummings
 * @license   http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @author    Michael Cummings <mgcummings@yahoo.com>
 */
namespace Yapeal\Filesystem;

use Pimple;
use Psr\Log\LogLevel;
use Yapeal\DependencyContainerTrait;
use Yapeal\Log\LoggerAwareTrait;

/**
 * Class UriTemplatesFinder
 *
 * @package Yapeal\Filesystem
 */
class UriTemplatesFinder
{
    use DependencyContainerTrait, LoggerAwareTrait;
    /**
     * @param Pimple      $container A small Dependency Injection Container.
     * @param string|null $searchPath
     */
    public function __construct(Pimple $container = null, $searchPath = null)
    {
        $this->setDependencyContainer($container);
        $this->setSearchPath($searchPath);
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
     * UriTemplatesFinder::findLibraryBase($path);
     * // $this->libraryBase = '/my/project/base'
     *
     * $path = 'my/web/site';
     * UriTemplatesFinder::findLibraryBase($path);
     * // $this->libraryBase = 'my/web/site'
     *
     * $path = '/my/project/base/deeper';
     * $base = 'deeper';
     * UriTemplatesFinder::findLibraryBase($path, $base);
     * // $this->libraryBase = '/my/project/base'
     *
     * $path = '/my/system/lib/some/other/library';
     * UriTemplatesFinder::findLibraryBase($path);
     * // $this->libraryBase = '/my/system'
     *
     * $path = 'C:\\my\project\lib';
     * UriTemplatesFinder::findLibraryBase($path);
     * // $this->libraryBase = 'C://my/project'
     * // Note all of the '\' changed to '/'.
     * </pre>
     *
     * The following examples would cause problems:
     * <pre>
     * $path = '/my/project/lib';
     * $base = '/lib';
     * UriTemplatesFinder::findLibraryBase($path, $base);
     * // The '/' is automatically prefixed to $base so becomes
     * // $base = '//lib' and
     * // $this->libraryBase = '/my/project/lib'
     * </pre>
     *
     * @param string $base
     *
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @return self
     * @uses UriTemplatesFinder::findVendorParent()
     */
    public function findLibraryBase($base = 'lib')
    {
        if (!is_string($base)) {
            $mess = '$base MUST be a string but given instead '
                . gettype($base);
            $this->getLogger()
                 ->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $path = $this->getSearchPath();
        $base = '/' . $base;
        $path = str_replace('\\', '/', $path);
        // Search up through $path until $base is no longer found.
        while (false !== strpos($path, $base)) {
            $path = dirname($path);
        }
        if (!file_exists($path) || !is_dir($path) || !is_readable($path)) {
            $mess = '$path is NOT accessible please check permissions on '
                . $path;
            $this->getLogger()
                 ->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $this->libraryBase = $path;
        return $this;
    }
    /**
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @return self
     */
    public function findTemplates()
    {
        $this->findLibraryBase();
        return $this;
    }
    /**
     * Finds parent directory of vendor path.
     *
     * Normally this should never need to be called directly if you use composer
     * standard directory layout as {@link UriTemplatesFinder::findTemplates()}
     * calls this method with a path that would allow the vendor parent path to
     * be found.
     *
     * If the method is give an accessible path with $vendor in it the method
     * will directly find the parent from $path. If not the method checks to see
     * if the $path is already an accessible parent or if not the method checks
     * to see if the $path or some part of it is a sibling to $vendor that the
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
     * UriTemplatesFinder::findVendorParent($path);
     * // $this->vendorParent = '/my/project/base'
     *
     * $path = 'my/web/site';
     * // and "my/web/site/$vendor" exists and is an accessible path.
     * UriTemplatesFinder::findVendorParent($path);
     * // $this->vendorParent = 'my/web/site'
     *
     * $path = '/my/project/base/externals';
     * $vendor = 'externals';
     * UriTemplatesFinder::findVendorParent($path, $vendor);
     * // $this->vendorParent = '/my/project/base'
     *
     * $path = '/my/system/vendor/some/other/library';
     * UriTemplatesFinder::findVendorParent($path);
     * // $this->vendorParent = '/my/system'
     * </pre>
     *
     * The following examples would cause problems:
     * <pre>
     * $path = 'C:\\my\project\vendor';
     * UriTemplatesFinder::findVendorParent($path);
     * // Windows style path using '\' will NOT match
     * // $vendor = '/vendor' after automatic prefixing of the '/'.
     *
     * $path = '/my/project/vendor';
     * $vendor = '/vendor';
     * UriTemplatesFinder::findVendorParent($path, $vendor);
     * // The '/' is automatically prefixed to $vendor so becomes
     * // $vendor = '//vendor' and will NOT match.
     * </pre>
     *
     * @param string $value
     *
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @return self
     */
    public function findVendorParent($value = 'vendor')
    {
        $path = $this->getParentPath($value);
        if (false === $path) {
            $mess = "Could NOT find ${value} parent in given search path: "
                . $this->getSearchPath();
            $this->getLogger()
                 ->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $this->vendorParent = $path;
        return $this;
    }
    /**
     * @param string $value
     *
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @return self
     */
    public function findYapealParent($value = 'Yapeal')
    {
        $path = $this->getParentPath($value);
        if (false === $path) {
            $mess = "Could NOT find ${value} parent in given search path: "
                . $this->getSearchPath();
            $this->getLogger()
                 ->log(LogLevel::WARNING, $mess);
            return $this;
        }
        $this->vendorParent = $path;
        return $this;
    }
    /**
     * @param string $child
     *
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @return string|false
     */
    public function getParentPath($child)
    {
        if (!is_string($child)) {
            $mess = '$child MUST be a string but given instead '
                . gettype($child);
            $this->getLogger()
                 ->log(LogLevel::WARNING, $mess);
            return false;
        }
        $path = $this->getSearchPath();
        $child = '/' . $child;
        // Search up through $path until $child is no longer found.
        while (false !== strpos($path, $child)) {
            $path = dirname($path);
        }
        while (!(file_exists($path . $child) && is_dir($path . $child)
            && is_readable($path . $child))) {
            if ($path == dirname($path)) {
                $mess = 'Could not find accessible $child\'s parent';
                $this->getLogger()
                     ->log(LogLevel::WARNING, $mess);
                return false;
            }
            $path = dirname($path);
        }
        if (!file_exists($path) || !is_dir($path) || !is_readable($path)) {
            $mess = '$path is NOT accessible please check permissions on '
                . $path;
            $this->getLogger()
                 ->log(LogLevel::WARNING, $mess);
            return false;
        }
        return $path;
    }
    /**
     * @throws \LogicException
     * @return string
     */
    public function getSearchPath()
    {
        if ($this->searchPath) {
            return $this->searchPath;
        } else {
            $mess = '$searchPath accessed before being set';
            throw new \LogicException($mess);
        }
    }
    /**
     * Used to persist the URI templates to the dependency container.
     */
    public function persist()
    {
        $container = $this->getDependencyContainer();
    }
    /**
     * @param string|null $value
     *
     * @return self
     */
    public function setSearchPath($value = null)
    {
        $this->searchPath = $value ? : __DIR__;
        return $this;
    }
    /**
     * @var string
     */
    private $libraryBase;
    /**
     * @var string Holds the path that will be used for finding the local URI
     * templates.
     */
    private $searchPath;
    /**
     * @var string
     */
    private $vendorParent;
}
