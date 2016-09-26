<?php

namespace Besepa\Test;


use Besepa\Client;
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

		$responseMock = new FakeResponse($json, new FakeRequest());
		$responseMock->code = 200;

		$this->client->method('get')->willReturn($responseMock);

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

		$responseMock = new FakeResponse($json, new FakeRequest());
		$responseMock->code = 200;

		$this->client->method('get')->willReturn($responseMock);

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

		$responseMock = new FakeResponse($json, new FakeRequest());
		$responseMock->code = 200;

		$this->client->method('post')->willReturn($responseMock);

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
