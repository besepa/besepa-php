<?php
/**
 *
 *
 * @author Asier Marqués <asiermarques@gmail.com>
 */

namespace Besepa\Exception;


class BesepaAuthException extends \Exception
{

    function __construct($url)
    {

        parent::__construct("Wrong API KEY to $url");


    }

}
