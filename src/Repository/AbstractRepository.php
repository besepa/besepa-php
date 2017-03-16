<?php

namespace Besepa\Repository;


use Besepa\Client;
use Besepa\Entity\EntityInterface;
use Besepa\Exception\BesepaCreationResultException;

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


	function mapEntity($instance)
    {
		return unserialize(sprintf(
			'O:%d:"%s"%s',
			strlen($this->getEntityName()),
			$this->getEntityName(),
			strstr(strstr(serialize($instance), '"'), ':')
		));
	}

    /**
     * @param int $page
     * @return array
     */
	function findAll($page=1)
	{

        $response_json = $this->client->get("/" . $this->getEndpointName() . '?page=' . $page);

		if($response_json !== false && isset($response_json->response))
		{
            $items = array();
            foreach ($response_json->response as $item){
                $items[] = $this->mapEntity($item);
            }
            return $items;

		}

        return array();
	}


    /**
     * @param $id
     * @return EntityInterface|null
     */
	function find($id)
	{

        $response_json = $this->client->get("/" . $this->getEndpointName() . "/" . $id);

		if($response_json !== false && isset($response_json->response)){

            return $this->mapEntity($response_json->response);

		}

        return null;

	}

    /**
     * @param $query
     * @param int $page
     * @return array
     */
	function query($query, $page=1)
    {
        $response_json = $this->client->get("/" . $this->getEndpointName() . '/search?query=' . $query . '&page=' . $page);

        if($response_json !== false && isset($response_json->response)){

            $items = array();
            foreach ($response_json->response as $item){
                $items[] = $this->mapEntity($item);
            }
            return $items;

        }

        return array();
    }

    /**
     * @param EntityInterface $item
     * @return mixed
     * @throws BesepaCreationResultException
     */
	function create(EntityInterface $item)
	{

		$response_json = $this->client->post("/" . $this->getEndpointName(), $item, $this->getResourceName());

        if($response_json !== false && isset($response_json->response)){

            return $this->mapEntity($response_json->response);
		}

		throw new BesepaCreationResultException($response_json);

	}


}