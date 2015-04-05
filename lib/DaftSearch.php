<?php
/**
 * The file is part of DaftSearch library
 *
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 *
 */

namespace DaftSearch;

/**
 * The DaftSearch Class
 *
 * @category   DaftSearchLib
 * @package    DaftSearch
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 *
 */

class DaftSearch
{
    /**
     * Daft api key
     *
     * @var string $apiKey
     */
    public static $apiKey;

    /**
     * Daft soap api url
     *
     * @var string $apiBase
     */
    public static $apiBase = 'http://api.daft.ie/v2/wsdl.xml';

    /**
     * Get the daft api key
     *
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Set the dat api key
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }
}