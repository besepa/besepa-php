<?php
namespace Besepa\Test;


use Httpful\Mime;
use Httpful\Response;

class FakeResponse extends Response{



	function __construct( $body, FakeRequest $request ) {

		$this->content_type = Mime::JSON;
		$this->request  = $request;
		$this->body = json_decode($body);

	}

}