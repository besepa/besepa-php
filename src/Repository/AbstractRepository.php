<?php

namespace Besepa\Repository;


use Besepa\Client;
use Besepa\Entity\EntityInterface;

abstract class AbstractRepository {

	/**
	 * @var Client
	 */
	protected $client;

    protected $customer_id;

	function setClient(Client $client)
	{
		$this->client = $client;
	}

	abstract function getEndpointName();

	abstract function getResourceName();

	abstract function getEntityName();

    function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

	function mapEntity($instance) {
		return unserialize(sprintf(
			'O:%d:"%s"%s',
			strlen($this->getEntityName()),
			$this->getEntityName(),
			strstr(strstr(serialize($instance), '"'), ':')
		));
	}

	function findAll()
	{

		$response = $this->client->get("/" . $this->getEndpointName());
		if($response->code == 200){
			if(isset($response->body->response)){

				$items = array();
				foreach ($response->body->response as $item){
					$items[] = $this->mapEntity($item);
				}
				return $items;

			}
		}

	}

	function find($id)
	{

		$response = $this->client->get("/" . $this->getEndpointName() . "/" . (int) $id);
		if($response->code == 200){
			if(isset($response->body->response)){

				return $this->mapEntity($response->body->response);

			}
		}

	}

	function create(EntityInterface $item)
	{

		$response = $this->client->post("/" . $this->getEndpointName(), $item, $this->getResourceName());
		if($response->code == 200 || $response->code == 201){
			if(isset($response->body->response)){

				return $this->mapEntity($response->body->response);

			}
		}

	}


}