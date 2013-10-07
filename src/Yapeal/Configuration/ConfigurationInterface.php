<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 10/1/13
 * Time: 8:37 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Yapeal\Configuration;


interface ConfigurationInterface {
    /**
     * @return self
     */
    public function fetchConfiguration();
    /**
     * @param string|string[] $value
     *
     * @return self
     */
    public function setConfigurationSource($value);
}
