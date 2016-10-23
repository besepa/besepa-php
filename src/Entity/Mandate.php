<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 23/10/16
 * Time: 20:03
 */

namespace Besepa\Entity;


class Mandate {

	const STATUS_PENDING_SIGNATURE  = "PENDING_SIGNATURE";
	const STATUS_SIGNED             = "SIGNED";
	const STATUS_EXPIRED            = "EXPIRED";
	const STATUS_USED               = "USED";


	public $description;
	public $status;
	public $signed_at;
	public $mandate_type;
	public $reference;
	public $scheme;
	public $used;
	public $signature_type;
	public $created_at;
	public $phone_number;
	public $id;
	public $url;
	public $signature_url;
	public $download_url;

}