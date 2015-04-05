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
 * The Api Resource Class
 *
 * @abstract
 * @category   DaftSearchLib
 * @package    DaftSearch
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

abstract class ApiResource
{

    /**
     * Get daft soap api url
     *
     * @return string
     */
    public static function baseUrl()
    {
        return DaftSearch::$apiBase;
    }

    /**
     * Get the name of the class, remove namespaceing and covert camel case to
     * underscore case before returning it.
     *
     * @return string
     */
    public static function className()
    {
        $className = get_called_class();
        // For namespaces: DaftSearch\Query etc.
        if ($postfixName = strrchr($className, '\\')) {
            $className = substr($postfixName, 1);
        }
        // convert Camel case to underscore lowercase: SearchSale -> search_sale
        $name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $className));
        return $name;
    }

    /**
     * Get the action name based on class name
     * @return string
     */
    public static function classAction()
    {
        return static::className();
    }

    /**
     * Parse optional parameters and perform a soap request
     *
     * @param string  $action   The action to perform request. e.g.
     *                          (search_sale, areas, ad_types etc.) for more
     *                          details see daft api documentation
     * @param array   $params   The parameters for property search request
     * @param array   $opts     The optional parameters for soap and other
     *                          request
     *
     * @return mixed  The results from daft soap api
     */
    protected static function staticRequest($action, $params, $opts)
    {
        $parsedOpts = RequestOpts::parse($opts);
        $apiRequestor = new ApiRequestor($parsedOpts->apiKey, static::baseUrl());
        $response = $apiRequestor->request($action, $params, $parsedOpts->opts['soap_opts']);
        return $response;
    }

    /**
     * Retrieve a soap request
     *
     * @param array $params @see ApiResource::staticRequest()
     * @param array $opts   @see ApiResource::staticRequest()
     *
     * @return mixed The results from daft soap api
     */
    protected static function apiRetrieve($params = null, $opts = null)
    {
        $action = static::classAction();
        $response = static::staticRequest($action, $params, $opts);
        return $response;
    }
}