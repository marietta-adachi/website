<?php
/**
 * Add maintenance mode
 *
 * @package    Maintenance
 * @version    0.1
 * @author     Hinashiki
 * @license    MIT License
 * @copyright  2015 - Hinashiki
 * @link       https://github.com/hinashiki/fuelphp-maintenance
 */

namespace Maintenance;

class HttpServerMaintenanceException extends \HttpException
{
	public function response()
	{
		return new \Response(\View::forge(\Config::get('maintenance.view')), 503);
	}
}
