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

class MaintenanceMode
{
	/**
	 * check maintenance mode
	 *
	 * @return void
	 */
	public static function check()
	{
		if(\Config::get('maintenance.maintenance_mode') === true)
		{
			throw new \HttpServerMaintenanceException('Maintenance mode.', 503);
		}
	}
}
