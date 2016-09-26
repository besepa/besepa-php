<?php
namespace Besepa\Repository;


class BankAccountRepository extends AbstractRepository{



	function getEndpointName()
	{
	    if(!$this->customer_id)
	        throw new \Exception(get_class($this) . " needs a customer_id");

		return 'customers/' . $this->customer_id . '/bank_accounts';
	}



	function getResourceName()
	{
		return 'bank_account';
	}

	function getEntityName()
	{
		return "Besepa\\Entity\\BankAccount";
	}

}