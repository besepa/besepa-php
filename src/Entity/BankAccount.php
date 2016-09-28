<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 30/8/16
 * Time: 18:44
 */

namespace Besepa\Entity;


class BankAccount implements EntityInterface
{

    public $id;

    public $iban;

    public $bic;

    public $bank_name;

    public $status;

    public $customer_id;

    public $mandate;

    public $created_at;

}