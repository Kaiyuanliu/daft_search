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
 * The Request Optional Parameters Class
 *
 * @abstract
 * @category   DaftSearchLib
 * @package    DaftSearch
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

class RequestOpts
{
    /**
     * Daft api key
     *
     * @var string $apiKey
     */
    public $apiKey;

    /**
     * Daft request optional parameters
     *
     * @var array $opts
     */
    public $opts;

    /**
     * RequestOpts Constructor
     *
     * @param null|string  $apiKey The daft api key
     * @param array        $opts   The daft request opts
     */
    public function __construct($apiKey = null, $opts = array())
    {
        $this->apiKey = $apiKey;
        $this->opts = $opts;
    }

    /**
     * Parse daft request optional parameters
     *
     * @param array $opts The daft request opts
     *
     * @return \DaftSearch\RequestOpts
     * @throws \DaftSearch\Exception\Api
     */
    public static function parse($opts)
    {
        $defaultOpts = array('soap_opts' => array('features' => SOAP_SINGLE_ELEMENT_ARRAYS));
        if (is_null($opts)) {
            return new RequestOpts(null, $defaultOpts);
        }

        if (is_array($opts)) {
            $key = null;
            if (array_key_exists('api_key', $opts)) {
                $key = $opts['api_key'];
            }
            if (array_key_exists('soap_opts', $opts)) {
                $defaultOpts['soap_opts'] = $opts['soap_opts'];
            }
            return new RequestOpts($key, $defaultOpts);
        }
        $errorMsg = 'error happened while parsing request opts';
        throw new Exception\Api($errorMsg);
    }
}