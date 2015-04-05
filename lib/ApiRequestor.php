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
 * The Api Request Class
 *
 * @category   DaftSearchLib
 * @package    DaftSearch
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

class ApiRequestor
{

    /**
     * Daft api key
     *
     * @var null|string $_apiKey
     */
    private $_apiKey;

    /**
     * Daft soap api url
     *
     * @var null|string $_apiBase
     */
    private $_apiBase;

    /**
     * Constructor
     * @param string|null $apiKey   The daft api key
     * @param string|null $apiBase  The daft api url
     */
    public function __construct($apiKey = null, $apiBase = null)
    {
        $this->_apiKey = $apiKey;
        if (!$apiBase) {
            $apiBase = DaftSearch::$apiBase;
        }
        $this->_apiBase = $apiBase;
    }

    /**
     * Perform a search request
     *
     * @param string      $action   The action to perform request. e.g.
     *                              (search_sale, areas, ad_types etc.) for more
     *                              details see daft api documentation
     * @param null|array  $params   The parameters for property search request
     * @param array       $soapOpts The optional parameters for soap request
     *
     * @return mixed The results from daft api
     * @throws \DaftSearch\Exception\Authentication
     * @todo Interpret results to make it more usable before returning it.
     */
    public function request(
        $action,
        $params = null,
        $soapOpts = array('features' => SOAP_SINGLE_ELEMENT_ARRAYS)
    ){
        if (!$params) {
            $params = array();
        }
        $result = $this->_request($action, $params, $soapOpts);
        return $result;
    }

    /**
     * @see ApiRequestor::request()
     */
    private function _request($action, $params, $soapOpts)
    {
        $currentApiKey = $this->_apiKey;
        if (!$currentApiKey) {
            $currentApiKey = DaftSearch::$apiKey;
        }

        if (!$currentApiKey) {
            $errorMsg = 'No API key provided. Please set API key before'
                . ' each action using "DaftSearch::setApiKey(<API KEY>)"';
            throw new Exception\Authentication($errorMsg);
        }

        $base = $this->_apiBase;
        if (!array_key_exists('api_key', $params)) {
            $params['api_key'] = $currentApiKey;
        }
        return $this->_soapRequest($action, $base, $params, $soapOpts);
    }

    /**
     * Handle soap request to daft api
     *
     * @param string  $action   @see ApiRequestor::request()
     * @param string  $base     The daft api url
     * @param array   $params   @see ApiRequestor::request()
     * @param array   $soapOpts @see ApiRequestor::request()
     *
     * @return mixed  The results from daft api
     * @throws \DaftSearch\Exception\Api
     * @throws \DaftSearch\Exception\Authentication
     * @throws \DaftSearch\Exception\Permission
     * @throws \DaftSearch\Exception\Unknown
     * @throws \Exception
     * @todo To check $action validation before make soap request, if it is
     *       invalid, throws Exception\Api exception
     */
    private function _soapRequest($action, $base, $params, $soapOpts)
    {
        try{
            $soapClient = new \SoapClient($base, $soapOpts);
            $response = $soapClient->$action($params);
            return $response;
        } catch (\SoapFault $e) {
            $this->_handleSoapException($e);
        }
    }

    /**
     * To handle soap errors
     *
     * @param \SoapFault $exception The soap fault exception
     *
     * @throws \DaftSearch\Exception\Api
     * @throws \DaftSearch\Exception\Authentication
     * @throws \DaftSearch\Exception\Permission
     * @throws \DaftSearch\Exception\Unknown
     * @throws \Exception
     */
    private function _handleSoapException($exception)
    {
        $exceptionCode = $exception->faultcode;
        $exceptionMsg = $exception->faultstring;
        switch ($exceptionCode) {
            case 'AuthenticationFailure':
                throw new Exception\Authentication($exceptionMsg);
                break;
            case 'PermissionFailure':
                throw new Exception\Permission($exceptionMsg);
                break;
            case 'UnknownFailure':
                throw new Exception\Unknown($exceptionMsg);
                break;
            case 'Client':
                throw new Exception\Api($exceptionMsg);
                break;
            default:
                throw new \Exception($exceptionMsg);
        }
    }
}