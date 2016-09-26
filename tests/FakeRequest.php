<?php
namespace Besepa\Test;


use Httpful\Mime;
use Httpful\Request;

class FakeRequest extends Request{



	function __construct() {
		$this->expected_type = Mime::JSON;
		$this->auto_parse = true;
	}

}