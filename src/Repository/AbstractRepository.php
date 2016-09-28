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

	function findAll($page=1)
	{

        $response_json = $this->client->get("/" . $this->getEndpointName() . '?page=' . $page);

		if($response_json !== false){

            $items = array();
            foreach ($response_json->response as $item){
                $items[] = $this->mapEntity($item);
            }
            return $items;

		}

	}

	function find($id)
	{

        $response_json = $this->client->get("/" . $this->getEndpointName() . "/" . (int) $id);

		if($response_json !== false && isset($response_json->response)){

            return $this->mapEntity($response_json->response);

		}

	}

	function query($query, $page=1)
    {
        $response_json = $this->client->get("/" . $this->getEndpointName() . '?query=' . $query . '&page=' . $page);

        if($response_json !== false){

            $items = array();
            foreach ($response_json->response as $item){
                $items[] = $this->mapEntity($item);
            }
            return $items;

        }
    }

	function create(EntityInterface $item)
	{

		$response_json = $this->client->post("/" . $this->getEndpointName(), $item, $this->getResourceName());

        if($response_json !== false && isset($response_json->response)){

            return $this->mapEntity($response_json->response);
		}

	}


}