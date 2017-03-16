<?php

namespace Besepa\Test;


use Besepa\Client;
use Besepa\Entity\BankAccount;
use Besepa\Entity\Customer;
use Besepa\Repository\CustomerRepository;

class CustomerRepositoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var CustomerRepository
	 */
	private $repo;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $client;

	function setUp() {

		parent::setUp();

		$this->client = $this->getMockBuilder('Besepa\Client')->getMock();

		$this->repo = new CustomerRepository();
	}

    function testCreateBankAccount()
    {

        $json = <<<JSON
{"response":{"name":"XXX","taxid":"XXX","reference":"cus20a24e2f958705","contact_name":"XXX","contact_email":"XXX@besepa.com","address_street":"XXX","address_city":"XXX","address_postalcode":"XXX","address_state":"XX","address_country":"XX","status":"ACTIVE","created_at":"2017-03-16T15:44:56.796+01:00","id":"cus20a24e2f958705","bank_accounts":[{"id":"ban577e6e467817a6","iban":"XXX","bic":"XXX","bank_name":"XXX","status":"PENDING_MANDATE","default":false,"created_at":"2017-03-16T15:44:56.000+01:00","mandate":{"id":"man5f4317a5cd1084","status":"PENDING_SIGNATURE","description":"Firmado fuera de BeSEPA.","reference":"man5f4317a5cd1084","mandate_type":"RECURRENT","scheme":"B2B","url":"https://sandboxapp.besepa.com/m/man5f4317a5cd1084","signature_type":"form","used":false,"created_at":"2017-03-16T15:44:56.835+01:00","account_id":"accb9583273c15f87ae5b764e1e266b"}}]}}
JSON;


        $this->client->method('post')->willReturn(json_decode($json));

        /**
         * @var $client Client
         */
        $client = $this->client;

        $this->repo->setClient($client);

        /**
         * @var $item Customer
         */
        $item = $this->repo->create(new Customer());

        $this->assertEquals("cus20a24e2f958705", $item->id);
        $this->assertGreaterThan(0, count($item->bank_accounts));
        $this->assertTrue($item->bank_accounts[0] instanceof BankAccount);
        $this->assertEquals("ban577e6e467817a6", $item->bank_accounts[0]->id);

    }

	function testFindAll(){

		$json = <<<JSON
{
				  "response": [
				    {
				      "name": "Revolucionarios S.A.",
				      "taxid": "A123456789",
				      "reference": "ez2014",
				      "contact_name": "Emiliano Zapata",
				      "contact_email": "zapata@test.com",
				      "contact_phone": "555101010",
				      "contact_language": "ES",
				      "address_street": "Avenida de la Revolución S/N",
				      "address_city": "Ali",
				      "address_postalcode": "01010",
				      "address_state": "Álava",
				      "address_country": "ES",
				      "status": "ACTIVE",
				      "id": "cus9878c9231d1d65a80a053684d91fa076",
				      "created_at": "Sun, 10 May 2015 15:47:12 UTC +00:00"
				    }
				  ],
				  "count": 1
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

    function testQuery(){

        $json = <<<JSON

{
  "response": [
    {
      "name": "Pancho Villa SLU",
      "taxid": "B98123232",
      "reference": "112370",
      "contact_name": "Pancho Villa",
      "contact_email": "pvilla@panchovilla.com",
      "contact_phone": "123456789",
      "address_street": "Avda. de la Revolución 12",
      "address_city": "Madrid",
      "address_postalcode": "28001",
      "address_state": "Madrid",
      "address_country": "ES",
      "status": "ACTIVE",
      "created_at": "2016-08-24T13:47:19.000+02:00",
      "id": "cusd53282955ce1f213304c563b026c",
      "group_ids": [
        "gro98c1450a23e80c9148d36aeeb64f",
        "grofaa892fda4478c05fe0ce89fb367"
      ]
    }
  ],
  "count": 1,
  "pagination": {
    "previous": null,
    "next": null,
    "current": 1,
    "per_page": 50,
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

        $items = $this->repo->query('B98123232');

        $this->assertGreaterThan(0, count($items));
        $this->assertInstanceOf($this->repo->getEntityName(), $items[0]);

    }

	function testFind(){

		$json = <<<JSON
{
				  "response": {
				      "name": "Revolucionarios S.A.",
				      "taxid": "A123456789",
				      "reference": "ez2014",
				      "contact_name": "Emiliano Zapata",
				      "contact_email": "zapata@test.com",
				      "contact_phone": "555101010",
				      "contact_language": "ES",
				      "address_street": "Avenida de la Revolución S/N",
				      "address_city": "Ali",
				      "address_postalcode": "01010",
				      "address_state": "Álava",
				      "address_country": "ES",
				      "status": "ACTIVE",
				      "id": "cus9878c9231d1d65a80a053684d91fa076",
				      "created_at": "Sun, 10 May 2015 15:47:12 UTC +00:00"
				    }
}
JSON;


		$this->client->method('get')->willReturn(json_decode($json));

		/**
		 * @var $client Client
		 */
		$client = $this->client;

		$this->repo->setClient($client);

		$item = $this->repo->find('cus9878c9231d1d65a80a053684d91fa076');

		$this->assertInstanceOf($this->repo->getEntityName(), $item);

		$this->assertEquals('cus9878c9231d1d65a80a053684d91fa076', $item->id);
		$this->assertEquals('A123456789', $item->taxid);
		$this->assertEquals('Revolucionarios S.A.', $item->name);

	}

	function testCreate(){

		$json = <<<JSON
{
  "response": {
    "name": "Pancho Villa SLU",
    "taxid": "B98123232",
    "reference": "11234",
    "contact_name": null,
    "contact_email": null,
    "contact_phone": null,
    "address_street": null,
    "address_city": null,
    "address_postalcode": null,
    "address_state": null,
    "address_country": null,
    "status": "ACTIVE",
    "id": "cus32887bc363e05d1b40ba2670b11a24b2",
    "created_at": "Sun, 10 May 2015 15:47:12 UTC +00:00"
  }
}
JSON;


		$this->client->method('post')->willReturn(json_decode($json));

		/**
		 * @var $client Client
		 */
		$client = $this->client;

		$this->repo->setClient($client);

		$data = new Customer();

		$item = $this->repo->create($data);


		$this->assertInstanceOf($this->repo->getEntityName(), $item);
		$this->assertEquals('cus32887bc363e05d1b40ba2670b11a24b2', $item->id);

	}

}
