<?php

namespace Besepa;


use Besepa\Entity\EntityInterface;
use Besepa\Exception\BesepaAuthException;
use Besepa\Repository\AbstractRepository;
use Httpful\Mime;
use Httpful\Request;

class Client {

	const API_URL     = "https://api.besepa.com/api/1";
    const API_URL_DEV = "https://sandbox.besepa.com/api/1";

	private $key;
	private $accountId;
    private $isProd;

	function init($key, $account_id, $prod_env=false)
    {
		$this->key       = $key;
		$this->accountId = $account_id;
        $this->isProd    = $prod_env;
	}

    /**
     * @param $repository_name
     * @return AbstractRepository
     * @throws \Exception
     */
	function getRepository($repository_name, $customer_id=null)
    {

		$class_name = "Besepa\\Repository\\{$repository_name}Repository";

		if(class_exists($class_name)) {

            /**
             * @var $instance AbstractRepository
             */
			$instance = new $class_name();
            $instance->setClient($this);
            $instance->setCustomerId($customer_id);

            return $instance;
		}

		throw new \Exception("Repository " . $class_name . " not found");

	}

    /**
     * @param EntityInterface $data
     * @param null $resource_name
     * @param bool $remove_id
     * @return mixed|string|void
     */
	function getResourceBody(EntityInterface $data, $resource_name=null, $remove_id=false)
    {

	    if($remove_id)
        {
            $data  = json_encode($data);
            $data = json_decode($data, true);
            if(isset($data["id"]))
                unset($data["id"]);

        }

		return $resource_name ? json_encode(array($resource_name => $data))
			                  : json_encode($data);
	}

    /**
     * @param $path
     * @return array|bool|mixed|object
     */
	function get($path)
    {

        $ch = $this->createCurlSession($this->getUrl() . $path);

        $body   = curl_exec($ch);
        $status = $this->getStatusCode($ch);
        curl_close($ch);

        if($status==401)
            throw new BesepaAuthException($this->getUrl());

        return $body? json_decode($body) : false;

	}

    /**
     * @param $path
     * @param EntityInterface $data
     * @param null $resource_name
     * @return array|bool|mixed|object
     */
	function post($path, EntityInterface $data, $resource_name=null)
    {

        $ch = $this->createCurlSession($this->getUrl() . $path);



        curl_setopt($ch, CURLOPT_POST,           1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $this->getResourceBody($data, $resource_name, true) );

        $body   = curl_exec ($ch);
        $status = $this->getStatusCode($ch);
        curl_close($ch);

        if($status==401)
            throw new BesepaAuthException($this->getUrl());


        return $body ? json_decode($body) : false;

	}

    /**
     * @param $url
     * @return resource
     */
	private function createCurlSession($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ' . $this->key));

        return $ch;
    }

    private function getStatusCode($ch)
    {

        $info = curl_getinfo($ch);

        return isset($info["http_code"]) ? $info["http_code"] : -1;
    }

    /**
     * @return string
     */
    private function getUrl()
    {
        return $this->isProd ? static::API_URL : static::API_URL_DEV;
    }

}