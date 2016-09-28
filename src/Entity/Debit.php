<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 30/8/16
 * Time: 18:39
 */

namespace Besepa\Entity;


class Debit implements EntityInterface
{

    public $id;

    public $reference;

    public $amount;

    public $currency;

    public $collect_at;

    public $sent_at;

    public $rejected_at;

    public $status;

    public $description;

    public $debtor_bank_account;

    public $creditor_bank_account;

    public $metadata;

    public $customer;



}