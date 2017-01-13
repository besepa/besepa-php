<?php

namespace Besepa\Test;


use Besepa\Client;
use Besepa\Entity\Debit;
use Besepa\Repository\DebitRepository;

class DebitRepositoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var DebitRepository
	 */
	private $repo;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $client;

	function setUp() {

		parent::setUp();

		$this->client = $this->getMockBuilder('Besepa\Client')->getMock();

		$this->repo = new DebitRepository();
        $this->repo->setCustomerId('cusa1654ec35f3745481bb0a984d8f8');
	}



	function testFind(){

		$json = <<<JSON
    {
        "response": {
            "amount": 1000,
            "currency": "EUR",
            "collect_at": "2014-11-15",
            "sent_at": null,
            "rejected_at": null,
            "status": "READY",
            "description": "desc",
            "id": "deb3482f4dc98245ec092581e4f507a",
            "reference": "REF123",
            "metadata": {
                "shipping": "UPS"
            },
            "customer": {
                "name": "Pancho Villa SLU",
                "taxid": "B98123232",
                "reference": "11232",
                "contact_name": "Pancho Villa",
                "contact_email": "pvilla@panchovilla.com",
                "contact_phone": "123456789",
                "address_street": "Avda. de la Revolución 12",
                "address_city": "Madrid",
                "address_postalcode": "28001",
                "address_state": "Madrid",
                "address_country": "ES",
                "status": "ACTIVE",
                "id": "cusa1654ec35f3745481bb0a984d8f8"
            },
            "debtor_bank_account": {
                "bank_name": "Banco Santander",
                "bic": "BSCHESMM",
                "iban": "ES7620770024003102575766",
                "status": "ACTIVE",
                "id": "ban9601a13105a897750917b223418c",
                "mandate": {
                    "description": "mandate",
                    "status": "SIGNED",
                    "signed_at": "2014-11-10T15:59:45.313Z",
                    "mandate_type": "RECURRENT",
                    "reference": "1415635184",
                    "scheme": "CORE",
                    "id": "manff3c2d4ea5ca29085c5c871ef2d2",
                    "url": "https://app.besepa.com/m/manff3c2d4ea5ca29085c5c871ef2d2"
                }
            },
            "creditor_bank_account": {
                "bank_name": "Banco Santander",
                "bic": "BSCHESMM",
                "iban": "ES7620770024003102575766",
                "status": "ACTIVE",
                "id": "ban60e4704d70add1851b676aa69fbc"
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

		$item = $this->repo->find('deb3482f4dc98245ec092581e4f507a');

		$this->assertInstanceOf($this->repo->getEntityName(), $item);

		$this->assertEquals('deb3482f4dc98245ec092581e4f507a', $item->id);
		$this->assertEquals('ban9601a13105a897750917b223418c', $item->debtor_bank_account->id);
		$this->assertEquals('1000', $item->amount);

	}

	function testCreate(){

		$json = <<<JSON
{
        "response": {
            "amount": 1000,
            "currency": "EUR",
            "collect_at": "2014-11-15",
            "sent_at": null,
            "rejected_at": null,
            "status": "READY",
            "description": "desc",
            "id": "deb3482f4dc98245ec092581e4f507a",
            "reference": "REF123",
            "metadata": {
                "shipping": "UPS"
            },
            "customer": {
                "name": "Pancho Villa SLU",
                "taxid": "B98123232",
                "reference": "11232",
                "contact_name": "Pancho Villa",
                "contact_email": "pvilla@panchovilla.com",
                "contact_phone": "123456789",
                "address_street": "Avda. de la Revolución 12",
                "address_city": "Madrid",
                "address_postalcode": "28001",
                "address_state": "Madrid",
                "address_country": "ES",
                "status": "ACTIVE",
                "id": "cusa1654ec35f3745481bb0a984d8f8"
            },
            "debtor_bank_account": {
                "bank_name": "Banco Santander",
                "bic": "BSCHESMM",
                "iban": "ES7620770024003102575766",
                "status": "ACTIVE",
                "id": "ban9601a13105a897750917b223418c",
                "mandate": {
                    "description": "mandate",
                    "status": "SIGNED",
                    "signed_at": "2014-11-10T15:59:45.313Z",
                    "mandate_type": "RECURRENT",
                    "reference": "1415635184",
                    "scheme": "CORE",
                    "id": "manff3c2d4ea5ca29085c5c871ef2d2",
                    "url": "https://app.besepa.com/m/manff3c2d4ea5ca29085c5c871ef2d2"
                }
            },
            "creditor_bank_account": {
                "bank_name": "Banco Santander",
                "bic": "BSCHESMM",
                "iban": "ES7620770024003102575766",
                "status": "ACTIVE",
                "id": "ban60e4704d70add1851b676aa69fbc"
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

		$data = new Debit();
        $data->reference = 'REF123';
        $data->debtor_bank_account_id = 'ban9601a13105a897750917b223418c';
        $data->amount = 1000;
        $data->description = 'desc';

		$item = $this->repo->create($data);

		$this->assertInstanceOf($this->repo->getEntityName(), $item);
		$this->assertEquals('deb3482f4dc98245ec092581e4f507a', $item->id);
        $this->assertEquals(1000, $item->amount);

	}

    function testFindAll(){

        $json = <<<JSON
{
  "response": [
    {
      "reference": "112318",
      "amount": 1000,
      "currency": "EUR",
      "collect_at": "2016-09-10",
      "sent_at": null,
      "status": "READY",
      "description": "desc",
      "created_at": "2016-08-26T15:38:33.000+02:00",
      "error_code": null,
      "platform_error_code": null,
      "metadata": null,
      "rejected_at": null,
      "id": "deb77d9ab9f264ccb2d3b05ac9e52d9",
      "customer": {
        "name": "Pancho Villa SLU",
        "taxid": "B98123232",
        "reference": "112316",
        "contact_name": "Pancho Villa",
        "contact_email": "pvilla@panchovilla.com",
        "contact_phone": "123456789",
        "address_street": "Avda. de la Revolución 12",
        "address_city": "Madrid",
        "address_postalcode": "28001",
        "address_state": "Madrid",
        "address_country": "ES",
        "status": "ACTIVE",
        "created_at": "2016-08-26T15:38:33.000+02:00",
        "id": "cus282adcbcaf0e4f0e0ced6ed4b027"
      },
      "debtor_bank_account": {
        "id": "ban8b0c797596d880140b6c798044ef",
        "iban": "ES7620770024003102575766",
        "bic": "BSCHESMMXXX",
        "bank_name": "Banco Santander",
        "status": "ACTIVE",
        "default": false,
        "created_at": "2016-08-26T15:38:33.000+02:00",
        "customer": {
          "name": "Pancho Villa SLU",
          "taxid": "B98123232",
          "reference": "112316",
          "contact_name": "Pancho Villa",
          "contact_email": "pvilla@panchovilla.com",
          "contact_phone": "123456789",
          "address_street": "Avda. de la Revolución 12",
          "address_city": "Madrid",
          "address_postalcode": "28001",
          "address_state": "Madrid",
          "address_country": "ES",
          "status": "ACTIVE",
          "created_at": "2016-08-26T15:38:33.000+02:00",
          "id": "cus282adcbcaf0e4f0e0ced6ed4b027"
        },
        "customer_id": "cus282adcbcaf0e4f0e0ced6ed4b027",
        "mandate": {
          "id": "man6cf093d433e3fcd4280aa22fe251",
          "signed_at": "2016-08-26T15:38:33.000+02:00",
          "status": "SIGNED",
          "description": "mandate",
          "reference": "1472218711",
          "mandate_type": "RECURRENT",
          "scheme": "CORE",
          "url": "http://localhost:3001/m/man6cf093d433e3fcd4280aa22fe251",
          "signature_type": "sms",
          "used": false,
          "created_at": "2016-08-26T15:38:33.000+02:00",
          "account_id": "acc837f7865cc098b88d14f501dd12d"
        }
      },
      "creditor_bank_account": {
        "id": "bandd9279e0aee620187b84d4360c9c",
        "iban": "ES7620770024003102575766",
        "bic": "BSCHESMMXXX",
        "bank_name": "Banco Santander",
        "status": "ACTIVE",
        "default": true,
        "created_at": "2016-08-26T15:38:33.000+02:00",
        "b2b_enabled": true,
        "b2b_suffix": "001",
        "core_enabled": true,
        "core_suffix": "000",
        "mandate": {
          "id": "man092664a56e5510c26580edfdd77e",
          "signed_at": "2016-08-26T00:00:00.000+02:00",
          "status": "PENDING_SIGNATURE",
          "description": "mandate",
          "reference": "1472218711",
          "mandate_type": "RECURRENT",
          "scheme": "CORE",
          "url": "http://localhost:3001/m/man092664a56e5510c26580edfdd77e",
          "signature_type": "sms",
          "used": false,
          "created_at": "2016-08-26T15:38:33.000+02:00",
          "account_id": "acc846f13ea87bbedd30bbbd6104925"
        }
      }
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



}
