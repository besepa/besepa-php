<?php

namespace Besepa;


use Besepa\Entity\EntityInterface;
use Besepa\Repository\AbstractRepository;
use Httpful\Mime;
use Httpful\Request;

class Client {

	const API_URL = "https://sandbox.besepa.com/api/1";

	private $key;
	private $accountId;

	function init($key, $account_id) {
		$this->key = $key;
		$this->accountId = $account_id;
	}

    /**
     * @param $repository_name
     * @return AbstractRepository
     * @throws \Exception
     */
	function getRepository($repository_name, $customer_id=null){

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

	function getResourceBody(EntityInterface $data, $resource_name=null, $remove_id=false){

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

	function get($path) {

		return Request::get(static::API_URL . $path)
			->expects(Mime::JSON)
			->addHeader('Authorization', 'Bearer ' . $this->key)
			->send();

	}

	function post($path, EntityInterface $data, $resource_name=null) {

		return Request::post(static::API_URL . $path)
			          ->body($this->getResourceBody($data, $resource_name, true))
		              ->expects(Mime::JSON)
		              ->addHeader('Authorization', 'Bearer ' . $this->key)
		              ->send();

	}

}