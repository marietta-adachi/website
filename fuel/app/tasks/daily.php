<?php

namespace Fuel\Tasks;

class Daily extends Base
{

	public function a()
	{
		$task = new \Tasks_Daily_A();
		$task->run();
	}

	public function b()
	{
		$task = new \Tasks_Daily_B();
		$task->run();
	}

}
