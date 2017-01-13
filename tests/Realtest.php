<?php
/**
 *
 *
 * @author Asier Marqués <asiermarques@gmail.com>
 */

namespace Besepa\Test;


use Besepa\Client;
use Besepa\Entity\Customer;
use Besepa\Entity\Debit;

class Realtest extends \PHPUnit_Framework_TestCase
{

    function testCreateFailDebit()
    {
        $client = new Client();
        $client->init("e80589b88699a6dc522433ab9ecac6d0fb025f3749b8061ab8d8b3bf0f2bb349", "accb9583273c15f87ae5b764e1e266b");


        $client->getRepository("BankAccount", "aaa")->findAll();

    }
}