<?php
/**
 * The file is part of DaftSearch library
 *
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 *
 */

namespace DaftSearch\Exception;

use Exception;

/**
 * The Exception Base Class
 *
 * @abstract
 * @category   DaftSearchLib
 * @package    DaftSearch\Exception
 * @author     Kaiyuan Liu
 * @version    0.0.1
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
abstract class Base extends Exception
{

    /**
     * Instantiate exception instance
     *
     * @param string $message The exception message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}