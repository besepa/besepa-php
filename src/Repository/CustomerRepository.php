<?php
namespace Besepa\Repository;


class CustomerRepository extends AbstractRepository{

	function getEndpointName()
	{
		return 'customers';
	}

	function getResourceName()
	{
		return 'customer';
	}

	function getEntityName()
	{
		return "Besepa\\Entity\\Customer";
	}

}