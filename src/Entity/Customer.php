<?php
namespace Besepa\Entity;


class Customer implements EntityInterface{

	public $id;

	public $name;

	public $taxid;

    public $reference;

    public $contact_name;

    public $contact_email;

    public $contact_phone;

    public $address_street;

    public $address_city;

    public $address_postalcode;

    public $address_state;

    public $address_country;

    public $status;

    public $created_at;

    /**
     * @var BankAccount
     */
    public $bank_account;

    public $bank_accounts=array();


}