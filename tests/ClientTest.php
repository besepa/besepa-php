<?php
namespace Besepa\Test;

use Besepa\Client;
use Besepa\Entity\Customer;
use Besepa\Repository\CustomerRepository;

class ClientTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Client
	 */
	private $client;

	function setUp(){
		parent::setUp();
		$this->client = new Client();
	}

	function testCheckConnection(){

		$this->client->init('e80589b88699a6dc522433ab9ecac6d0fb025f3749b8061ab8d8b3bf0f2bb349', 'accb9583273c15f87ae5b764e1e266b');
		$response = $this->client->get('/customers');

		$this->assertEquals(200, $response->code);
	}

	function testGetRepository(){

		$repo = $this->client->getRepository("Customer");
		$class_name = get_class(new CustomerRepository($this->client));

		$this->assertInstanceOf($class_name, $repo);
	}

	function testGetResourceBody(){
		$item = new Customer();
		$item->id = 1;
        $item->name = "test";

		$body = $this->client->getResourceBody($item, "test");
		$body = json_decode($body, true);

		$this->assertTrue(isset($body["test"]));
		$this->assertEquals(1, $body["test"]["id"]);



        $body2 = $this->client->getResourceBody($item, null, true);
        $body2 = json_decode($body2, true);

        $this->assertFalse(isset($body2["id"]));
        $this->assertEquals("test", $body2["name"]);
	}





}
