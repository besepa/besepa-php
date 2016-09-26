<?php
namespace Besepa\Repository;


class DebitRepository extends AbstractRepository{



	function getEndpointName()
	{
	    if(!$this->customer_id)
	        throw new \Exception(get_class($this) . " needs a customer_id");

		return 'customers/' . $this->customer_id . '/debits';
	}



	function getResourceName()
	{
		return 'debit';
	}

	function getEntityName()
	{
		return "Besepa\\Entity\\Debit";
	}

}