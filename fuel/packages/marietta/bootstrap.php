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

\Autoloader::add_namespace('Maintenance', __DIR__.'/classes/');
\Autoloader::add_core_namespace('Maintenance');
\Config::load('maintenance', true);

\Autoloader::add_classes(array(
	'Maintenance\\HttpServerMaintenanceException' => __DIR__.'/classes/httpexceptions.php',
	'Maintenance\\MaintenanceMode'                => __DIR__.'/classes/maintenance.php',
));
