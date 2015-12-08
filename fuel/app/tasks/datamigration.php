<?php

namespace Fuel\Tasks;

/**
 * 
 */
class Datamigration
{

	/**
	 *
	 * @return string
	 */
	public function run($type)
	{
		\Config::load("base");
		$taskName = "DATA MIGRATION";
		\Cli::write(\TaskUtil::decorate(\Config::get("system.code") . " {$taskName} START"));
		$model = new \Model_Task_Datamigration();
		$model->run($type);
		\Cli::write(\TaskUtil::decorate(\Config::get("system.code") . " {$taskName} END"));
	}

}
?>

