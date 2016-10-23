<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 30/8/16
 * Time: 18:44
 */

namespace Besepa\Entity;


class BankAccount implements EntityInterface
{

    const STATUS_ACTIVE             = "ACTIVE";
    const STATUS_PENDING_MANDATE    = "PENDING_MANDATE";
    const STATUS_REPLACED           = "REPLACED";
    const STATUS_REMOVED            = "REMOVED";
    const STATUS_CANCELLED          = "CANCELLED";

    public $id;

    public $iban;

    public $bic;

    public $bank_name;

    public $status;

    public $customer_id;

    /**
     * @var Mandate
     */
    public $mandate;

    public $created_at;

}