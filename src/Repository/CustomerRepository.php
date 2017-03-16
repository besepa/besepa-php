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

    function mapEntity($instance)
    {

        $instance = unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($this->getEntityName()),
            $this->getEntityName(),
            strstr(strstr(serialize($instance), '"'), ':')
        ));

        if(count($instance->bank_accounts))
        {
            $ba = array();
            foreach ($instance->bank_accounts as $account)
            {
                $ba[] = $this->mapBankAccount($account);
            }
            $instance->bank_accounts = $ba;
        }

        return $instance;
    }

    private function mapBankAccount($instance)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen("Besepa\\Entity\\BankAccount"),
            "Besepa\\Entity\\BankAccount",
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }

}