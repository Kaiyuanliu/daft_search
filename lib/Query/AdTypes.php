<?php
/**
 * The file is part of DaftSearch library
 *
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 *
 */

namespace DaftSearch\Query;

use DaftSearch\ApiResource;

/**
 * The Ad types Class
 *
 * @category   DaftSearchLib
 * @package    DaftSearch\Query
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

class AdTypes extends ApiResource
{

    /**
     * @param array|null $params The parameters for searching ad types
     * @param array|null $opts   The optional parameters for soap request
     *
     * @return ApTypes
     */
    public static function retrieve($params = null, $opts = null)
    {
        return self::apiRetrieve($params, $opts);
    }
}