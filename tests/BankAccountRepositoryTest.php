<?php

namespace Besepa\Test;


use Besepa\Client;
use Besepa\Entity\BankAccount;
use Besepa\Repository\BankAccountRepository;

class BankAccountRepositoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var BankAccountRepository
	 */
	private $repo;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $client;

	function setUp() {

		parent::setUp();

		$this->client = $this->getMockBuilder('Besepa\Client')->getMock();

		$this->repo = new BankAccountRepository();
        $this->repo->setCustomerId('cus9878c9231d1d65a80a053684d91fa076');
	}

	function testFindAll(){

		$json = <<<JSON
{
  "response": [
    {
      "id": "ban1521cdcb3f897fd5c324d501def4",
      "iban": "ES7620770024003102575766",
      "bic": "BSCHESMMXXX",
      "bank_name": "Banco Santander",
      "status": "PENDING_MANDATE",
      "default": true,
      "created_at": "2016-08-26T10:52:28.000+02:00",
      "b2b_enabled": true,
      "b2b_suffix": "001",
      "core_enabled": true,
      "core_suffix": "000"
    }
  ],
  "count": 1,
  "pagination": {
    "previous": null,
    "next": null,
    "current": 1,
    "per_page": 30,
    "count": 1,
    "pages": 1
  }
}
JSON;


		$this->client->method('get')->willReturn(json_decode($json));

		/**
		 * @var $client Client
		 */
		$client = $this->client;

		$this->repo->setClient($client);

		$items = $this->repo->findAll();

		$this->assertGreaterThan(0, count($items));
		$this->assertInstanceOf($this->repo->getEntityName(), $items[0]);

	}

	function testFind(){

		$json = <<<JSON
{
  "response": {
    "id": "ban21d18575aae931777012afba1b0b8148",
    "bank_name": "Banco Santander",
    "bic": "BSCHESMM",
    "iban": "ES7610771024203102575766",
    "status": "PENDING_MANDATE",
    "customer_id": "cusf11b647d2cc16e503fe8ba36f88c",
    "created_at": "Sun, 10 May 2015 15:47:12 UTC +00:00",
    "mandate": {
      "description": "",
      "status": "PENDING_SIGNATURE",
      "signed_at": null,
      "mandate_type": "RECURRENT",
      "reference": "mana6ce0b3ba60dec29d61ffef90a4c",
      "scheme": "B2B",
      "used": false,
      "signature_type": "checkbox",
      "created_at": "Sun, 10 May 2015 15:47:12 UTC +00:00",
      "phone_number": null,
      "id": "manf08d870d327041854beca9ad6117",
      "url": "http://sandboxapp.besepa.com/m/manf08e870d427040854beca9ad6117"
    }
  }
}
JSON;


		$this->client->method('get')->willReturn(json_decode($json));

		/**
		 * @var $client Client
		 */
		$client = $this->client;

		$this->repo->setClient($client);

		$item = $this->repo->find('ban21d18575aae931777012afba1b0b8148');

		$this->assertInstanceOf($this->repo->getEntityName(), $item);

		$this->assertEquals('ban21d18575aae931777012afba1b0b8148', $item->id);

	}

	function testCreate(){

		$json = <<<JSON
{
  "response": {
    "id": "ban21d18575aae931777012afba1b0b8148",
    "bank_name": "Banco Santander",
    "bic": "BSCHESMM",
    "iban": "ES7610771024203102575766",
    "status": "PENDING_MANDATE",
    "customer_id": "cusf11b647d2cc16e503fe8ba36f88c",
    "created_at": "Sun, 10 May 2015 15:47:12 UTC +00:00",
    "mandate": {
      "description": "",
      "status": "PENDING_SIGNATURE",
      "signed_at": null,
      "mandate_type": "RECURRENT",
      "reference": "mana6ce0b3ba60dec29d61ffef90a4c",
      "scheme": "B2B",
      "used": false,
      "signature_type": "checkbox",
      "created_at": "Sun, 10 May 2015 15:47:12 UTC +00:00",
      "phone_number": null,
      "id": "manf08d870d327041854beca9ad6117",
      "url": "http://sandboxapp.besepa.com/m/manf08e870d427040854beca9ad6117"
    }
  }
}
JSON;


		$this->client->method('post')->willReturn(json_decode($json));

		/**
		 * @var $client Client
		 */
		$client = $this->client;

		$this->repo->setClient($client);

		$data = new BankAccount();
        $data->iban = 'ES7610771024203102575766';

		$item = $this->repo->create($data);

		$this->assertInstanceOf($this->repo->getEntityName(), $item);
		$this->assertEquals('ban21d18575aae931777012afba1b0b8148', $item->id);

	}

}
