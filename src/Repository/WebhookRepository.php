<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 23/10/16
 * Time: 21:15
 */

namespace Besepa\Repository;


class WebhookRepository extends AbstractRepository {

	function getEndpointName() {
		return 'webhooks';
	}

	function getResourceName() {
		return 'webhook';
	}

	function getEntityName() {
		return "Besepa\\Entity\\Webhook";
	}

}