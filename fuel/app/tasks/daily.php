<?php

namespace Fuel\Tasks;

class Daily
{

	/**
	 *
	 * @return string
	 */
	public function set_reservable()
	{
		\Config::load("base");
		$taskName = __METHOD__;
		\Cli::write(\TaskUtil::decorate(\Config::get("system.code") . " {$taskName} START"));

		$model = new \Model_Task_Setreservable();
		$model->run();

		\Cli::write(\TaskUtil::decorate(\Config::get("system.code") . " {$taskName} END"));
	}

}
?>

