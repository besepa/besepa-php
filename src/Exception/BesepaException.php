<?php
/**
 *
 *
 * @author Asier Marqués <asiermarques@gmail.com>
 */

namespace Besepa\Exception;


class BesepaException extends \Exception
{
    /**
     * @var array
     */
    private $messages=array();

    function __construct($response_data)
    {

        $message = "Unexpected error";

        if(isset($response_data->error))
        {
            $message = $response_data->error;
        }

        if(isset($response_data->error_description))
        {
            $message = $message . " " . $response_data->error_description;
        }

        if(isset($response_data->messages) && is_array($response_data->messages))
        {
            $this->messages = $response_data->messages;
        }

        parent::__construct($message);

    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

}
